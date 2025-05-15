<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('create', Category::class);

        $validated = $request->validated();

        $category = new Category();
        $category->name = $validated['name'];

        try {
            $category->save();
            return redirect()->back()->with('success', 'Catégorie créée avec succès!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création de la catégorie.');
        }
    }
}
