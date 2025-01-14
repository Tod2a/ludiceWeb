<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $games = Game::where('name', 'LIKE', '%' . $request->query('search') . '%')
            ->orderByDesc('published_at')
            ->paginate(12);

        return inertia('Games/index', ['games' => $games]);
    }
}
