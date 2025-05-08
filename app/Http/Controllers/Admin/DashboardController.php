<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role && $user->role->name === 'User') {
            return redirect()->route('connected.homepage');
        }

        return Inertia::render('Admin/Dashboard');
    }
}
