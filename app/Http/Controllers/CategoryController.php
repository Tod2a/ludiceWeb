<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function search(Request $request)
    {
        $name = $request->input('name');

        $categories = Category::all();

        if ($name) {
            $categories->where('name', 'like', '%' . $name . '%');
        }

        $result = $categories->paginate(10);

        return response()->json($result);
    }
}
