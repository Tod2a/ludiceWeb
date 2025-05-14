<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string',
            'category' => 'nullable|string',
            'publisher' => 'nullable|string',
            'creator' => 'nullable|string',
            'userId' => 'nullable|integer|exists:users,id',
        ]);

        $query = $request->input('query');
        $category = $request->input('category');
        $publisher = $request->input('publisher');
        $creator = $request->input('creator');


        $games = Game::with(['categories', 'publishers', 'creators']);


        if ($query) {
            $games->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($query) . '%']);
        }

        if ($category) {
            $games->whereHas('categories', function ($query) use ($category) {
                $query->where('name', $category);
            });
        }

        if ($publisher) {
            $games->whereHas('publishers', function ($query) use ($publisher) {
                $query->where('name', $publisher);
            });
        }

        if ($creator) {
            $games->whereHas('creators', function ($query) use ($creator) {
                $query->where('name', $creator);
            });
        }

        $result = $games->paginate(12);

        return response()->json($result);
    }

    public function random()
    {
        return response()->json([
            'message' => "hello"
        ]);
    }
}
