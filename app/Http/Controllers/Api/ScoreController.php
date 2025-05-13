<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ScoreSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store()
    {
        return response()->json([
            'message' => "hello"
        ]);
    }
}
