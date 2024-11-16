@extends('layouts/contentNavbarLayout')

@section('title', 'Product Edit')

@section('content')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header"><a href="{{route('product-management')}}">Product Management</a> / Product Edit</h5>
      
      <form action="{{ route('product-update') }}" method="POST" enctype="multipart/form-data" class="card-body demo-vertical-spacing demo-only-element">
        @csrf
        @method('PUT')
        <input type="hidden" id="productid" name="productid" value="{{$product->id}}">
        <label class="form-label" for="Productname">ProductName</label>
        <div class="input-group">
        <span class="input-group-text">@</span>
        <input type="text" class="form-control" id="productname" name="productname" placeholder="Productname" aria-describedby="Productname" value="{{$product->name}}" />
        </div>

        <label class="form-label" for="upload">Upload</label>
        <div class="input-group">
          <input type="file" class="form-control" id="file" name="file" required>
        </div>

        <label class="form-label" for="Price">Price</label>
        <div class="input-group">
        <span class="input-group-text">@</span>
        <input type="text" class="form-control" id="price" name="price" placeholder="Price" aria-describedby="Price"  value="{{$product->price}}" />
        </div>

        <div class="d-flex flex-row justify-content-end align-items-center">
            <button class="btn btn-info waves-effect waves-light">Update</button>
            <a href="{{ route('product-management') }}" class="btn btn-danger waves-effect waves-light">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection