<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index(Request $request)
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
