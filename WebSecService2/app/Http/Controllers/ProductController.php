<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:products|max:64',
            'name' => 'required|max:256',
            'price' => 'required|numeric|min:0',
            'model' => 'required|max:128',
            'description' => 'nullable',
            'photo' => 'nullable|image|max:2048'
        ]);

        $product = new Product($validated);

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('products', 'public');
            $product->photo = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    // ✅ دالة عرض المنتج الواحد
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // ✅ دالة تعديل المنتج
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => "required|max:64|unique:products,code,$product->id",
            'name' => 'required|max:256',
            'price' => 'required|numeric|min:0',
            'model' => 'required|max:128',
            'description' => 'nullable',
            'photo' => 'nullable|image|max:2048'
        ]);

        $product->update($validated);

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('products', 'public');
            $product->photo = $imagePath;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // ✅ دالة حذف المنتج
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
