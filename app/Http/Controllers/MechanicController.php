<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function search(Request $request)
    {
        $name = $request->input('name');

        $mechanics = Mechanic::all();

        if ($name) {
            $mechanics->where('name', 'like', '%' . $name . '%');
        }

        $result = $mechanics->paginate(10);

        return response()->json($result);
    }
}
