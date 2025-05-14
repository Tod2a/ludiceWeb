<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TemplateSection;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(int $game)
    {
        $sections = TemplateSection::where('game_id', $game)->get();

        return response()->json(['sections' => $sections]);
    }
}
