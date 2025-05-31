<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
        ]);

        $name = $request->input('name');

        $mechanics = Mechanic::query();

        if ($name) {
            $mechanics->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%']);
        }

        $result = $mechanics->paginate(10);

        return response()->json($result);
    }
}
