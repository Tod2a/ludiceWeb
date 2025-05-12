<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use Illuminate\Http\Request;

class CreatorController extends Controller
{
    public function search(Request $request)
    {
        $name = $request->input('name');

        $creators = Creator::query();

        if ($name) {
            $creators = $creators->where(function ($query) use ($name) {
                $query->whereRaw('LOWER(firstname) LIKE ?', ['%' . strtolower($name) . '%'])
                    ->orWhereRaw('LOWER(lastname) LIKE ?', ['%' . strtolower($name) . '%']);
            });
        }

        $result = $creators->paginate(10);

        return response()->json($result);
    }
}
