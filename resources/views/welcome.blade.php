@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row ml-10">
        <h1>Products Catalog</h1>
    </div>

    <div class="container">
        @if(sizeof($products) > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-6 col-sm-4 mx-6 mb-3">
                <div class="card text-white bg-secondary" style="width: 18rem;">
                    <img class="card-img-top" src="{{$product->image}}" alt="Card image cap" height="200px">
                    <div class="card-body">
                        <h5 class="card-title">{{strtoupper($product->name)}}</h5>
                        <p class="card-text">{{env('CURRENCY') . number_format($product->price,2)}}</p>
                        <a href="{{route('show-product',['id'=>$product->id])}}" class="btn btn-primary">View Product</a>
                        <a href="{{route('collect-buyer-info', [$product->name, $product->price])}}" class="btn btn-success">Buy Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center">No Products Available!</div>

        @endif
    </div>
</div>

@endsection