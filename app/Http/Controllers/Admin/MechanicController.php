<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMechanicRequest;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MechanicController extends Controller
{
    public function store(StoreMechanicRequest $request)
    {
        Gate::authorize('create', Mechanic::class);

        $validated = $request->validated();

        $mechanic = new Mechanic();
        $mechanic->name = $validated['name'];

        try {
            $mechanic->save();
            return redirect()->back()->with('success', 'Mecanique créée avec succès!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création de la mécanique.');
        }
    }
}
