<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreatorRequest;
use App\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CreatorController extends Controller
{
    public function store(StoreCreatorRequest $request)
    {
        Gate::authorize('create', Creator::class);

        $validated = $request->validated();

        $creator = new Creator();
        $creator->firstname = $validated['firstname'];
        $creator->lastname = $validated['lastname'];

        try {
            $creator->save();
            return redirect()->back()->with('success', 'Créateur créé avec succès!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du créateur.');
        }
    }
}
