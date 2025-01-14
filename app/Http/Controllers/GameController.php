<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Creator;
use App\Models\Game;
use App\Models\Publisher;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();
        $creators = Creator::all();
        $categories = Category::all();

        return inertia('Games/index', ['publishers' => $publishers, 'categories' => $categories, 'creators' => $creators]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $publisher = $request->input('publisher');
        $creator = $request->input('creator');

        $games = Game::with(['categories', 'publishers', 'creators']);

        if ($query) {
            $games->where('name', 'like', '%' . $query . '%');
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
}
