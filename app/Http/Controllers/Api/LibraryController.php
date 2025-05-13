<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Creator;
use App\Models\Game;
use App\Models\User;

class LibraryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::with('library')->find($user->id);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function store(int $game)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($user->library()->where('game_id', $game)->exists()) {
            return response()->json(['message' => 'Game already in library'], 400);
        }

        $gameModel = Game::find($game);

        if (!$gameModel) {
            return response()->json(['message' => 'Game not found.'], 404);
        }

        $user->library()->attach($game);

        return response()->json(['message' => "Jeu ajouté avec succès."], 200);
    }

    public function destroy(int $game)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!$user->library()->where('game_id', $game)->exists()) {
            return response()->json(['message' => 'Game not in library'], 400);
        }

        $gameModel = Game::find($game);

        if (!$gameModel) {
            return response()->json(['message' => 'Game not found.'], 404);
        }

        $user->library()->detach($game);

        return response()->json(['message' => "Jeu retiré avec succès."], 200);
    }
}
