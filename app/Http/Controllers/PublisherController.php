<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function search(Request $request)
    {
        $name = $request->input('name');

        $publishers = Publisher::all();

        if ($name) {
            $publishers->where('name', 'like', '%' . $name . '%');
        }

        $result = $publishers->paginate(10);

        return response()->json($result);
    }
}
