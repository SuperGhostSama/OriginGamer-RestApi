<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());

        return response()->json(['message' => 'Category updated successfully.', 'data' => $category], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }

    public function filterByCategory($category_name)
    {
        $category = Category::where('category', $category_name)->firstOrFail();
        $products = Product::where('category_id', $category->id)->get();
        return response()->json($products);

    }
}