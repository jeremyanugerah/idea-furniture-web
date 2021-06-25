@extends('layouts.app')

@section('content')    

<div class="big-container" style="background-color: #f5d7b5; padding: 40px; min-height: 100vh;">
        <div class="container rounded" style="background-color: none; padding: 40px; min-height: 100px;">
            @foreach ($productTypes as $productType)
                {{-- Conditional for making a row in every fourth iteration --}}
                @if (($loop->iteration -1) % 4 == 0)
                    <div class="row justify-content-start">
                @endif
                    <div class="col-3" style="padding: 0;">
                        <div class="card text-center shadow-sm border-0" style="border-radius: 0; width: 100%; padding: 20px;">
                            {{-- Dipslay the image of the Product Type, if theres is no image, display the default image ('no image') --}}
                            <a href="/product/filtered/{{ $productType->id}}">
                                <img src="{{$productType->image}}" onerror="this.onerror=null;this.src='/storage/images/noimage.png';" class="card-img-top" style="width: 180px; height: 180px"alt="...">
                            </a>
                            <div class="card-body">
                                <a class="nav-link p-0" style="color: brown" href="/product/filtered/{{ $productType->id}}"><h5 class="card-title padding-0">{{ $productType->name }}</h5></a>
                                @auth
                                    {{-- Check if the user's role is admin then show the edit and delete button --}}
                                    @if(Auth::user()->role == 'admin')
                                        <a class="btn btn-outline-primary" style="display: inline-block;" href="/productType/{{ $productType->id }}/edit">Update</a>
                                        <form class="" style="display: inline-block;" action="/productType/{{ $productType->id }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                {{-- Close the row if it is the end of the row iteration--}}
                @if ($loop->index != 0 and $loop->iteration % 4 == 0)
                    </div>
                @endif    
            @endforeach
        </div>
    </div>
     
@endsection