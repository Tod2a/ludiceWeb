<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Creator;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();
        $creators = Creator::all();
        $categories = Category::all();
        $id = Auth::user()->id;
        $user = User::with('library')->find($id);

        return inertia('Games/index', ['publishers' => $publishers, 'categories' => $categories, 'creators' => $creators, 'user' => $user]);
    }

    public function show()
    {
        return inertia('Games/show');
    }

    public function search(Request $request)
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
        $user = $request->input('userId');

        if ($user) {
            $games = Game::with(['categories', 'publishers', 'creators', 'library'])
                ->whereHas('library', function ($query) use ($user) {
                    $query->where('users.id', $user);
                });
        } else {
            $games = Game::with(['categories', 'publishers', 'creators']);
        }

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
