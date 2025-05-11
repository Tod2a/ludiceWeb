<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomepageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('connected.homepage');
        }

        return Inertia::render('Homepage');
    }
}
