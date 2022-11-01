@extends('layouts.app')

@section('content')
<div class="container">
    @if(!empty($product))
    <div class="row ml-10">
        <h3 class="card-title">{{strtoupper($product->name)}}</h3>
    </div>
    <div class="card">
        <img class="card-img-top mx-10" height="400px" width="80%" src="{{$product->image}}" alt="Card image cap">
        <div class="card-body">
            <p class="card-title">Price: {{env('CURRENCY') . number_format($product->price,2)}}</p>
            <a href="{{route('catalog')}}" class="btn btn-primary">Go Back</a>
        </div>
    </div>
    @endif
</div>
@endsection