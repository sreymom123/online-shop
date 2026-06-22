<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug',
        'description', 'price', 'stock', 'image'
    ];

    // Product នៅក្នុង Category មួយ
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product មាន Reviews ច្រើន
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}