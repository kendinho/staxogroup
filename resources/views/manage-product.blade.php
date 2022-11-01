@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row ml-10">
        <h3 class="card-title">{{isset($product) ? 'Edit Product' : 'Add Product'}}</h3>
    </div>

    <form method="POST" action="{{isset($product) ? route('product.update',['product' => $product->id]) : route('product.store')}}" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
        @method('PATCH')
        @endif
        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" name="name" class="form-control" id="productName" aria-describedby="productName" placeholder="Enter Product Name" value="{{isset($product) ? $product->name :''}}">
            <small id="productName" class="form-text text-muted">Kindly enter a descriptive name for the product</small>
        </div>

        <div class="form-group">
            <label for="productPrice">Product Price in {{env('CURRENCY')}}</label>
            <input type="text" name="price" class="form-control" id="productPrice" placeholder="Enter Product Price" value="{{isset($product) ? number_format($product->price,2) :''}}">
        </div>

        <div class="form-group">
            <label for="productImage">Product Image</label>
            @if(isset($product))
            <img src="{{$product->image}}"><br>
            @endif
            <input type="file" name="image" class="form-control-file" id="productImage">
        </div>
        <br>
        <div class="form-group">
            <a href="{{route('product.index')}}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>

</div>

</div>
@endsection