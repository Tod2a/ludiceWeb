<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Creator;
use App\Models\Game;
use App\Models\Mechanic;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Game::class);

        return Inertia('Admin/Games/index');
    }

    public function search(Request $request)
    {
        Gate::authorize('viewAny', Game::class);

        $name = $request->input('name');

        $games = Game::with('publishers', 'creators');

        if ($name) {
            $games->where('name', 'like', '%' . $name . '%');
        }

        $result = $games->paginate(12);

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Game::class);

        $publishers = Publisher::all();
        $creators = Creator::all();
        $categories = Category::all();
        $mechanics = Mechanic::all();

        return Inertia('Admin/Games/create', ['publishers' => $publishers, 'creators' => $creators, 'categories' => $categories, 'mechanics' => $mechanics]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $game = Game::findOrFail($id);

        Gate::authorize('update', $game);

        return Inertia('Admin/Games/edit', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::withCount('library')->findOrFail($id);

        Gate::authorize('delete', $game);

        if ($game->library_count > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer un jeu qui se trouve dans une ludothèque.');
        }

        $game->delete();

        return redirect()->back()->with('success', 'Jeu supprimé avec succès.');
    }
}
