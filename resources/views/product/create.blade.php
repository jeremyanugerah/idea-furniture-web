@extends('layouts.app')
@section('content')
<div class="big-container" style="background-color: #f5d7b5; min-height: 100vh; padding: 50px 100px 50px 100px;">
    <div class="container-fluid" style="background-color: white; min-height: 100vh; padding:50px 70px 50px 70px;">
        <h1 class="title" style="color: brown;">Add Product</h1>
        <form action="/product" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' border-danger' : '' }}" id="name" name="name" value="{{ old('name')}}">
                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
            </div>

            <div class="form-group">
                <label for="inputImage">Image</label>
                <div class="custom-file">
                    <input type="file" class="form-control{{ $errors->has('image') ? ' border-danger' : '' }}" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" name="image">
                    <label class="custom-file-label" for="inputGroupFile04">Choose Image</label>
                </div>
                <small class="form-text text-danger">{!! $errors->first('image') !!}</small>
            </div>

            <div class="form-group">
                <label for="inputType">Product Type</label>
                <select id="inputType" class="custom-select my-1 mr-sm-2" name="type">
                    @foreach ($productTypes as $productType)
                        <option value={{ $productType->id }}>{{ $productType->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" class="form-control{{ $errors->has('stock') ? ' border-danger' : '' }}" id="stock" name="stock" value="{{ old('stock') }}">
                <small class="form-text text-danger">{!! $errors->first('stock') !!}</small>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control{{ $errors->has('price') ? ' border-danger' : '' }}" id="price" name="price" value="{{ old('price') }}">
                <small class="form-text text-danger">{!! $errors->first('price') !!}</small>
            </div>

            <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control{{ $errors->has('description') ? ' border-danger' : '' }}" id="description" name="description" rows="3">{{old('description')}}</textarea>
                    <small class="form-text text-danger">{!! $errors->first('description') !!}</small>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            
        </form>
    </div>
</div>
@endsection