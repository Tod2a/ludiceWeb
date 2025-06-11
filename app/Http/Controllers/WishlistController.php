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

        $user = User::with('library')->find($id);

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

        $games = Game::with(['categories', 'publishers', 'creators', 'library'])
            ->whereHas('wishlist', function ($query) use ($user) {
                $query->where('users.id', $user);
            });

        if ($query) {
            $games->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($query) . '%']);
        }

        $result = $games->paginate(12);

        return response()->json($result);
    }
}
