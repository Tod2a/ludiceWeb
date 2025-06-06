<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
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

        $request->validate([
            'name' => 'nullable|string|max:100',
        ]);

        $name = $request->input('name');

        $games = Game::with('publishers', 'creators');

        if ($name) {
            $games->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%']);
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

        return Inertia('Admin/Games/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        Gate::authorize('create', Game::class);

        $validated = $request->validated();

        $game = Game::make();
        $game->name = $validated['name'];
        $game->published_at = $validated['published_at'];
        $game->description = $validated['description'];
        $game->min_players = $validated['min_players'];
        $game->max_players = $validated['max_players'];
        $game->average_duration = $validated['average_duration'];
        $game->EAN = $validated['EAN'];
        $game->suggestedage = $validated['suggestedage'];
        $game->is_expansion = $validated['is_expansion'];

        $path = $request->file('imgurl')->store('images/games', 'public');
        $game->img_path = '/storage/' . $path;

        $game->save();

        $publisherIds = collect($validated['publishers'])->pluck('id')->toArray();
        $game->publishers()->sync($publisherIds);

        $creatorIds = collect($validated['creators'])->pluck('id')->toArray();
        $game->creators()->sync($creatorIds);

        $mechanicIds = collect($validated['mechanics'])->pluck('id')->toArray();
        $game->mechanics()->sync($mechanicIds);

        $categoryIds = collect($validated['categories'])->pluck('id')->toArray();
        $game->categories()->sync($categoryIds);
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
        $game = Game::with('creators', 'publishers', 'mechanics', 'categories')->findOrFail($id);

        Gate::authorize('update', $game);

        return Inertia('Admin/Games/edit', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, string $id)
    {
        $game = Game::with('creators', 'publishers', 'mechanics', 'categories')->findOrFail($id);

        Gate::authorize('update', $game);

        $validated = $request->validated();

        $game->name = $validated['name'];
        $game->published_at = $validated['published_at'];
        $game->description = $validated['description'];
        $game->min_players = $validated['min_players'];
        $game->max_players = $validated['max_players'];
        $game->average_duration = $validated['average_duration'];
        $game->EAN = $validated['EAN'];
        $game->suggestedage = $validated['suggestedage'];
        $game->is_expansion = $validated['is_expansion'];

        if ($validated['imgurl']) {
            $path = $request->file('imgurl')->store('images/games', 'public');
            $game->img_path = '/storage/' . $path;
        }

        $game->save();

        $publisherIds = collect($validated['publishers'])->pluck('id')->toArray();
        $game->publishers()->sync($publisherIds);

        $creatorIds = collect($validated['creators'])->pluck('id')->toArray();
        $game->creators()->sync($creatorIds);

        $mechanicIds = collect($validated['mechanics'])->pluck('id')->toArray();
        $game->mechanics()->sync($mechanicIds);

        $categoryIds = collect($validated['categories'])->pluck('id')->toArray();
        $game->categories()->sync($categoryIds);

        return redirect()->route('games.edit', $game->id);
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
