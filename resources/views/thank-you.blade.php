@extends('layouts.app')

@section('content')
<div class="container">
    @if(!empty($user))
    <div class="row ml-10">
        <h3 class="card-title">Thank you {{ucwords($user->name)}} for your purchase! </h3>

        <br>
        <div class="col-3 form-group">
            <a href="{{route('catalog')}}" class="btn btn-primary">Home</a>
        </div>
    </div>
    @endif
</div>
@endsection