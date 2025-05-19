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
        $game = Game::with(['categories', 'mechanics', 'publishers', 'creators'])->findOrFail($id);

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
        $userId = Auth::user()->id;
        $user = User::find($userId);

        $gamesQuery = $user->library()->with(['mechanics', 'categories'])->get();

        // Filters
        $filteredGames = $gamesQuery->filter(function ($game) use ($request) {

            if ($request->has('players') && ($game->min_players > $request->players || $game->max_players < $request->players)) {
                return false;
            }

            if ($request->has('duration') && $game->average_duration > $request->duration) {
                return false;
            }

            if ($request->has('age') && $game->suggestedage < $request->age) {
                return false;
            }

            if ($request->has('mechanics')) {
                $mechanicIds = is_array($request->mechanics) ? $request->mechanics : [$request->mechanics];
                if (!$game->mechanics->pluck('id')->intersect($mechanicIds)->count()) {
                    return false;
                }
            }

            if ($request->has('categories')) {
                $categoryIds = is_array($request->categories) ? $request->categories : [$request->categories];
                if (!$game->categories->pluck('id')->intersect($categoryIds)->count()) {
                    return false;
                }
            }

            return true;
        });

        if ($filteredGames->isEmpty()) {
            return response()->json([
                'message' => 'No game found matching the criteria.'
            ], 404);
        }

        $randomGame = $filteredGames->random();

        return response()->json([
            'game' => $randomGame
        ]);
    }
}
