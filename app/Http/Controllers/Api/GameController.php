<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => "hello"
        ]);
    }

    public function random()
    {
        return response()->json([
            'message' => "hello"
        ]);
    }

    public function filters()
    {
        return response()->json([
            'message' => "hello"
        ]);
    }
}
