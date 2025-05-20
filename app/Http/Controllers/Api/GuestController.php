<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $userId = Auth::user()->id;

        $guestsQuery = User::find($userId)->guests();

        if ($name) {
            $guestsQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%']);
        }

        $guests = $guestsQuery->get();

        return response()->json([
            'guests' => $guests,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
        ]);

        $guest = new Guest();
        $guest->name = $validated['name'];
        $guest->user_id = Auth::id();
        $guest->save();

        $guest->save();

        return response()->json(['message' => 'Invité créé avec succès.'], 200);
    }
}
