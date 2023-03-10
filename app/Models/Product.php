<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = ['title', 'description', 'price', 'content', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
