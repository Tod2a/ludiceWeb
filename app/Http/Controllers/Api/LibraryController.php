<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Creator;
use App\Models\User;

class LibraryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::with('library')->find($user->id);

        return response()->json([
            'user' => $user,
        ]);
    }
}
