<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Creator;
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
        $user = User::with('libraryGames')->find($id);

        return Inertia('Library/index', ['publishers' => $publishers, 'categories' => $categories, 'creators' => $creators, 'user' => $user]);
    }
}
