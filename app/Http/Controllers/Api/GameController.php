<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show(int $id)
    {
        $userId = Auth::id();

        $game = Game::with(['categories', 'mechanics', 'publishers', 'creators'])->findOrFail($id);

        $inLibrary = false;

        if ($userId) {
            $user = User::findOrFail($userId);
            $inLibrary = $user->library()->where('game_id', $id)->exists();
        }

        $game->in_library = $inLibrary;

        return response()->json($game);
    }

    /**
     * Get a random game from the authenticated user's library filtered by optional criteria.
     *
     * This method retrieves all games from the user's library along with their mechanics and categories,
     * then filters them based on the request parameters such as number of players, duration, age, mechanics, and categories.
     * Finally, it returns one random game from the filtered collection.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing optional filtering parameters:
     *      - players (int): Filter games that support this number of players.
     *      - duration (int): Filter games with an average duration less than or equal to this value (in minutes).
     *      - age (int): Filter games suitable for this minimum suggested age.
     *      - mechanics (array|int): Filter games that have at least one of the specified mechanic IDs.
     *      - categories (array|int): Filter games that have at least one of the specified category IDs.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing either:
     *      - The randomly selected game matching the filters (key: 'game')
     *      - A 404 JSON error message if no game matches the criteria.
     */
    public function random(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $gamesQuery = $user->library()->with(['mechanics', 'categories']);

        if ($request->has('players')) {
            $players = (int) $request->players;
            $gamesQuery->where('min_players', '<=', $players)
                ->where('max_players', '>=', $players);
        }

        if ($request->has('duration')) {
            $duration = (int) $request->duration;
            $gamesQuery->where('average_duration', '<=', $duration);
        }

        if ($request->has('age')) {
            $age = (int) $request->age;
            $gamesQuery->where('suggestedage', '<=', $age);
        }

        if ($request->has('mechanics')) {
            $mechanicIds = is_array($request->mechanics) ? $request->mechanics : [$request->mechanics];
            $gamesQuery->whereHas('mechanics', function ($query) use ($mechanicIds) {
                $query->whereIn('mechanics.id', $mechanicIds);
            });
        }

        if ($request->has('categories')) {
            $categoryIds = is_array($request->categories) ? $request->categories : [$request->categories];
            $gamesQuery->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        $filteredGames = $gamesQuery->get();

        if ($filteredGames->isEmpty()) {
            return response()->json([
                'message' => 'Aucun jeu ne correspond aux critères.'
            ], 404);
        }

        $randomGame = $filteredGames->random();

        return response()->json([
            'game' => $randomGame
        ]);
    }
}
