<?php

namespace App\Http\Controllers\api;

use App\Data\ScoreSheetData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScoreSheetRequest;
use App\Models\ScoreSheet;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index(?int $game = null)
    {
        $user = Auth::user();

        $scoreSheets = ScoreSheet::with([
            'game:id,name',
            'sections' => function ($query) {
                $query->with(['guest:id,name', 'user:id,name']);
            }
        ])
            ->whereHas('sections', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });

        if ($game) {
            $scoreSheets = $scoreSheets->where('game_id', $game);
        }

        $response = $scoreSheets->paginate(12);

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScoreSheetRequest $request)
    {
        $user = Auth::user();
        $data = new ScoreSheetData($request->validated());

        // Verify that each section contains a user id
        foreach ($data->sections as $section) {
            $hasUser = collect($section->scores)->contains(fn($score) => $score->user_id === $user->id);
            if (!$hasUser) {
                return response()->json([
                    'message' => 'Chaque section doit inclure un score pour l\'utilisateur authentifié.'
                ], 422);
            }
        }

        // Verify than each section got the same players
        $referenceIds = collect($data->sections[0]->scores)->map(
            fn($score) =>
            $score->user_id ? 'user_' . $score->user_id : 'guest_' . $score->guest_id
        )->sort()->values()->toArray();

        foreach ($data->sections as $index => $section) {
            $currentIds = collect($section->scores)->map(
                fn($score) =>
                $score->user_id ? 'user_' . $score->user_id : 'guest_' . $score->guest_id
            )->sort()->values()->toArray();

            if ($referenceIds !== $currentIds) {
                return response()->json([
                    'message' => "Incohérence des scores à l'index de section $index. Toutes les sections doivent avoir des scores pour les mêmes joueurs."
                ], 422);
            }
        }

        // Save in database
        DB::beginTransaction();

        try {
            $scoreSheet = new ScoreSheet();
            $scoreSheet->game_id = $data->game_id;
            $scoreSheet->save();

            foreach ($data->sections as $sectionData) {
                foreach ($sectionData->scores as $scoreData) {
                    $section = new Section();
                    $section->score_sheet_id = $scoreSheet->id;
                    $section->score = $scoreData->score ?? 0;
                    $section->name = $sectionData->name ?? 'Unnamed Section';

                    if (isset($scoreData->user_id)) {
                        $section->user_id = $scoreData->user_id;
                    }

                    if (isset($scoreData->guest_id)) {
                        $section->guest_id = $scoreData->guest_id;
                    }

                    $section->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Feuille de score et sections enregistrées avec succès.',
                'score_sheet_id' => $scoreSheet->id,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'enregistrement.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
