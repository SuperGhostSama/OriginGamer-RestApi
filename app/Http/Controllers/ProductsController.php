<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index()
    {
        return Product::with('category')->get();
    }

    public function show(Product $product)
    {
        return $product->load('category');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $user = Auth::user();
        $product = Product::create($validatedData + ['user_id' => $user->id]);
    

        return response()->json(['message' => 'Product created successfully.', 'data' => $product], 201);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $user = Auth::user();
        if(!$user->can('edit All product') && $user->id != $product->user_id){
            return response()->json(['message' => "Can't update a product that isn't yours!"]);
        }

        $product->update($validatedData);

        return response()->json(['message' => 'Product updated successfully.', 'data' => $product], 200);
    }

    public function destroy(Product $product)
    {   
        $user = Auth::user();
        if(!$user->can('delete All product') && $user->id != $product->user_id){
            return response()->json(['message' => "Can't delete a product that isn't yours!"]);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }
}