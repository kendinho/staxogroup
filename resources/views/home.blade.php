@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 style="float: left;margin-right:10px">Manage Products</h4>
                    <a href="{{route('product.create')}}" class="btn btn-success btn-sm" style="margin-left: 10px;">New Product</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        @if(sizeof($products) > 0)
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td><img src="{{$product->image}}" height="80px" width="80px" alt=""></td>
                                <td>{{$product->name}}</td>
                                <td>{{config('app.currency') . number_format($product->price,2)}}</td>
                                <td><a class="btn btn-primary" href="{{route('product.edit',['product' => $product->id])}}">Edit</a></td>
                                <td>
                                    <!-- <a class="btn btn-danger" href="{{route('product.destroy',['product' => $product->id])}}" onclick="return confirm('Are you sure?')">Delete</a> -->
                                    <form method="POST" action="{{route('product.destroy',['product' => $product->id])}}">
                                        @csrf
                                        @method('DELETE')

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-danger delete-product" value="Delete">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        <div>
                            <h4>No Data Found!</h4>
                        </div>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.delete-product').click(function(e) {
        e.preventDefault()
        if (confirm('Are you sure?')) {
            // Post the form
            $(e.target).closest('form').submit()
        }
    });
</script>
@endsection