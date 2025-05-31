<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\PatchNote;
use App\Models\User;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(AnalyticsService $analytics)
    {
        $user = Auth::user();

        $totalGames = Game::count();

        $verifiedUsers = User::whereNotNull('email_verified_at')->count();

        $patchNotes = PatchNote::latest()->with(['user'])->get();

        $thisWeekStart = Carbon::now()->startOfWeek()->toDateString();
        $thisMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $today = Carbon::now()->toDateString();

        if ($user && $user->role && $user->role->name === 'User') {
            return redirect()->route('connected.homepage');
        }

        return Inertia::render('Admin/Dashboard', [
            'appStartWeek' => $analytics->getEventCount('app_start', $thisWeekStart, $today),
            'appStartMonth' => $analytics->getEventCount('app_start', $thisMonthStart, $today),
            'selectedGameWeek' => $analytics->getEventCount('selected_game', $thisWeekStart, $today),
            'selectedGameMonth' => $analytics->getEventCount('selected_game', $thisMonthStart, $today),
            'totalGames' => $totalGames,
            'verifiedUsers' => $verifiedUsers,
            'patchNotes' => $patchNotes,
        ]);
    }
}
