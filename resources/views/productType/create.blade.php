@extends('layouts.app')
@section('content')
<div class="big-container" style="background-color: #f5d7b5; min-height: 100vh; padding: 50px 100px 50px 100px;">
    <div class="container-fluid" style="background-color: white; min-height: 100vh; padding:50px 70px 50px 70px;">
        <h1 class="title" style="color: brown;">Add Product Type</h1>
        <form action="/productType" method="POST" enctype="multipart/form-data">
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

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection