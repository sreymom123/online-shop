<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    // ទទួលយក Categories ទាំងអស់
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return response()->json($categories);
    }

    // ទទួលយក Category តែមួយ
    public function show($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        return response()->json($category);
    }
}