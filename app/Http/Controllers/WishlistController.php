<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;

        $user = User::with(['library', 'wishlist'])->find($id);

        return Inertia('Wishlist/index', ['user' => $user]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string',
            'userId' => 'nullable|integer|exists:users,id',
        ]);

        $query = $request->input('query');
        $user = $request->input('userId');

        $games = Game::with(['categories', 'publishers', 'creators', 'library', 'wishlist'])
            ->whereHas('wishlist', function ($query) use ($user) {
                $query->where('users.id', $user);
            });

        if ($query) {
            $games->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($query) . '%']);
        }

        $result = $games->paginate(12);

        return response()->json($result);
    }

    public function store(int $game)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('wishlist')->with('error', 'User not found');
        }

        if ($user->wishlist()->where('game_id', $game)->exists()) {
            return redirect()->route('wishlist')->with('error', 'Jeu déjà dans la liste de souhaits');
        }

        if ($user->library()->where('game_id', $game)->exists()) {
            $user->library()->detach($game);
        }

        $user->wishlist()->attach($game);

        return redirect()->back()->with('success', 'Jeu ajouté dans la liste de souhaits');
    }

    public function destroy(int $game)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('wishlist')->with('error', 'User not found');
        }

        if (!$user->wishlist()->where('game_id', $game)->exists()) {
            return redirect()->route('wishlist')->with('error', 'Jeu introuvable dans la liste de souhaits');
        }

        $user->wishlist()->detach($game);

        return redirect()->back();
    }
}
