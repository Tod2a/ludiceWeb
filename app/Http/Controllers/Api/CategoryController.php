<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
        ]);

        $name = $request->input('name');

        $categories = Category::query();

        if ($name) {
            $categories->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%']);
        }

        $result = $categories->paginate(10);

        return response()->json($result);
    }
}
