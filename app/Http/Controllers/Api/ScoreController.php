<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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

        return response()->json($scoreSheets->get());
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'game_id' => 'required|exists:games,id',
            'sections' => 'required|array|min:1',
            'sections.*.scores' => 'required|array|min:1',
            'sections.*.scores.*.score' => 'nullable|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Création de la feuille de score
            $scoreSheet = new ScoreSheet();
            $scoreSheet->game_id = $request->game_id;
            $scoreSheet->save();

            foreach ($request->sections as $sectionData) {
                foreach ($sectionData['scores'] as $scoreData) {
                    $section = new Section();
                    $section->score_sheet_id = $scoreSheet->id;
                    $section->score = $scoreData['score'];

                    if (isset($scoreData['user_id']) && $scoreData['user_id'] == $user->id) {
                        $section->user_id = $user->id;
                    } elseif (isset($scoreData['guest_id'])) {
                        $section->guest_id = $scoreData['guest_id'];
                    } else {
                        throw new \Exception('Each score must have either user_id or guest_id.');
                    }

                    $section->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Score sheet and sections saved successfully.',
                'score_sheet_id' => $scoreSheet->id,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while saving.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
