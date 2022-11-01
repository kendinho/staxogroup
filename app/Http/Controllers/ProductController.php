<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home', ['products' => Product::get()]);
    }

    public function create()
    {
        return view('manage-product');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
        $path = '/storage/';

        if ($request->hasFile('image')) {
            $path .= $request->image->storeAs('images', 'mypicture' . rand(1, 1000) . '.jpg', 'public');

            Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'image' => $path
            ]);
        }

        return to_route('product.index')->with('success', 'Product Successfully Added!');
    }

    public function edit(Product $product)
    {
        return view('manage-product', ['product' => $product]);
    }

    public function update(Request $request, $product)
    {
        $path = '/storage/';

        if ($request->hasFile('image')) {
            $path .= $request->image->storeAs('images', 'mypicture' . rand(1, 1000) . '.jpg', 'public');
            $request['image'] = $path;
        }

        Product::findorFail($product)->update($request->all());

        return to_route('product.index')->with('success', 'Product Successfully Updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return to_route('product.index')->with('success', 'Product Successfully Deleted!');
    }
}
