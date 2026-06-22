<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // មើល Categories ទាំងអស់
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // ទំព័របង្កើត Category ថ្មី
    public function create()
    {
        return view('admin.categories.create');
    }

    // រក្សាទុក Category ថ្មី
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category បានបង្កើតជោគជ័យ!');
    }

    // មើល Category តែមួយ
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    // ទំព័រកែ Category
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Update Category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category បានកែប្រែជោគជ័យ!');
    }

    // លប់ Category
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category បានលប់ជោគជ័យ!');
    }
}