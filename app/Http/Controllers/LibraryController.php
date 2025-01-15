<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Creator;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LibraryController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();
        $creators = Creator::all();
        $categories = Category::all();
        $id = Auth::user()->id;
        $user = User::with('library')->find($id);

        return Inertia('Library/index', ['publishers' => $publishers, 'categories' => $categories, 'creators' => $creators, 'user' => $user]);
    }

    public function store(int $game)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('library')->with('error', 'User not found');
        }

        if ($user->library()->where('game_id', $game)->exists()) {
            return redirect()->route('library')->with('error', 'Game already in the library');
        }

        $user->library()->attach($game);

        return redirect()->route('connected.homepage')->with('success', 'Game added to library');
    }

    public function destroy()
    {
        //
    }
}
