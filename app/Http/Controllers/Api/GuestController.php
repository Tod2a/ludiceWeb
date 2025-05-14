<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::with('guests')->find($userId);

        return response()->json([
            'guests' => $user->guests,
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
