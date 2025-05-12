<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function search(Request $request)
    {
        $name = $request->input('name');

        $query = Publisher::query();

        if ($name) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%']);
        }

        $result = $query->paginate(10);

        return response()->json($result);
    }
}
