@extends('layouts/contentNavbarLayout')

@section('title', 'Product Add')

@section('content')
<div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header"><a href="{{route('product-management')}}">Product Management</a> / Product Add</h5>
      
      <form action="{{ route('product-save') }}" method="POST" enctype="multipart/form-data" class="card-body demo-vertical-spacing demo-only-element">
        @csrf
        <label class="form-label" for="Productname">ProductName</label>
        <div class="input-group">
        <span class="input-group-text">@</span>
        <input type="text" class="form-control" id="productname" name="productname" placeholder="Productname" aria-describedby="Productname" />
        </div>

        <label class="form-label" for="upload">Upload</label>
        <div class="input-group">
          <input type="file" class="form-control" id="file" name="file" required>
        </div>

        <label class="form-label" for="Price">Price</label>
        <div class="input-group">
        <span class="input-group-text">@</span>
        <input type="text" class="form-control" id="price" name="price" placeholder="Price" aria-describedby="Price" />
        </div>

        <div class="d-flex flex-row justify-content-end align-items-center">
            <button class="btn btn-info waves-effect waves-light">Save</button>
            <a href="{{ route('product-management') }}" class="btn btn-danger waves-effect waves-light">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection