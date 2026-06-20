<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Dummy data produk
    private $products = [
        ['id' => 1, 'name' => 'Laptop', 'price' => 15000000, 'stock' => 10],
        ['id' => 2, 'name' => 'Mouse', 'price' => 250000, 'stock' => 50],
        ['id' => 3, 'name' => 'Keyboard', 'price' => 500000, 'stock' => 30],
        ['id' => 4, 'name' => 'Monitor', 'price' => 3000000, 'stock' => 15],
    ];

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->products
        ]);
    }

    public function show($id)
    {
        $product = collect($this->products)->firstWhere('id', (int)$id);
        
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $newProduct = [
            'id' => count($this->products) + 1,
            ...$validated
        ];

        return response()->json([
            'status' => 'success',
            'data' => $newProduct,
            'message' => 'Product created successfully'
        ], 201);
    }
}