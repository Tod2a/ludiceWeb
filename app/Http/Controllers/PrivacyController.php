<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PrivacyController extends Controller
{
    public function index()
    {
        return Inertia::render('Privacy');
    }
}
