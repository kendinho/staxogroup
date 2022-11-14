@extends('layouts.app')

@section('content')


<div class="container-fluid">


    <div class="container">
        <h1>Products Catalog</h1>
        @if(sizeof($products) > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-6 col-sm-4 mx-6 mb-3">
                <div class="card text-white bg-secondary" style="width: 18rem;">
                    <img class="card-img-top" src="{{$product->image}}" alt="Card image cap" height="200px">
                    <div class="card-body">
                        <h5 class="card-title">{{strtoupper($product->name)}}</h5>
                        <p class="card-text">{{config('app.currency') . number_format($product->price,2)}}</p>
                        <a href="{{route('show-product',['id'=>$product->id])}}" class="btn btn-primary">View Product</a>
                        <a href="{{route('collect-buyer-info', [$product->id])}}" class="btn btn-success">Buy Now</a>
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