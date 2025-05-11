<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => "hello"
        ]);
    }

    public function store()
    {
        return response()->json([
            'message' => "hello"
        ]);
    }
}
