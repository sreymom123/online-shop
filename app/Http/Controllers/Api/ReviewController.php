<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($id)
    {
        $reviews = Review::with('user')
            ->where('product_id', $id)
            ->latest()
            ->get();
        return response()->json($reviews);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $exists = Review::where('user_id', $request->user()->id)
            ->where('product_id', $id)
            ->first();

        if ($exists) {
            return response()->json(['message' => 'អ្នកបាន Review រួចហើយ!'], 409);
        }

        $review = Review::create([
            'user_id'    => $request->user()->id,
            'product_id' => $id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return response()->json($review->load('user'), 201);
    }
}