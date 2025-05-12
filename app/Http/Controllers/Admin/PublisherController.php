<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PublisherController extends Controller
{
    public function store(StorePublisherRequest $request)
    {
        Gate::authorize('create', Publisher::class);

        $validated = $request->validated();

        $publisher = new Publisher();
        $publisher->name = $validated['name'];

        try {
            $publisher->save();
            return redirect()->back()->with('success', 'Éditeur créé avec succès!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'éditeur.');
        }
    }
}
