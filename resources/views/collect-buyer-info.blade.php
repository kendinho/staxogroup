@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row ml-10">
        <h3 class="card-title">Kindly provide your name and email for identifaction purpose</h3>
    </div><br>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{route('store-buyer',[$product,$price])}}">
        @csrf
        <div class="form-group">
            <label for="buyerName">Buyer Name</label>
            <input type="text" name="name" class="form-control" id="buyerName" placeholder="Buyer Name">
        </div>

        <div class="form-group">
            <label for="buyerEmail">Buyer Email</label>
            <input type="email" name="email" class="form-control" id="buyerEmail" placeholder="abc@gmail.com">
        </div>
        <br>
        <div class="form-group">
            <a href="{{route('catalog')}}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>

</div>

</div>
@endsection