<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        return view('welcome', ['products' => Product::get()])->with('info', 'Some Info');
    }

    public function show($id)
    {
        return view('show-product', ['product' => Product::findorFail($id)]);
    }
}
