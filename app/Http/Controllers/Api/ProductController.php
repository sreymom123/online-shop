<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ទទួលយក Products ទាំងអស់
    public function index(Request $request)
{
        $products = Product::with('category')
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->get(); // ← shows all products

            return response()->json($products);
        }

    // ទទួលយក Product តែមួយ
    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->findOrFail($id);

        return response()->json($product);
    }

    // ស្វែងរក Products
    public function search(Request $request)
    {
        $products = Product::with('category')
            ->when($request->q, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->paginate(12);

        return response()->json($products);
    }
}