@extends('layouts.app')

@section('content') 
<div class="big-container" style="background-color: #f5d7b5; padding-top: 80px; min-height:100vh;">
        <div class="container rounded" style="background-color: white; padding: 40px; min-height: 30vh;">
            
            <div class="row justify-content-start">
                <div class="col-4 text-center"  style="padding: 0;">
                    <img src="{{ $product->image }}" onerror="this.onerror=null;this.src='/storage/images/noimage.png';" class="card-img-top border" alt="..." style="width: 350px; height: 350px" >
                </div>
                <div class="col-8"  style="padding-left: 30px; padding-top: 20px;">
                    <div class="texts-container">
                        <h3 >{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                        <h5 class="card-price">Rp {{ number_format("$product->price", 0, ",", ".") }}</h5>
                        <p>Stock: {{ $product->stock }}</p>
                        <hr>
                        
                        {{-- kerjain paling akhir aja soalnya btuh user id --}}
                        {{-- tambahin user id ke url nya --}}

                        @auth
                            @if(Auth::user()->role == 'member')
                                <form action="/cartItem" method="POST">
                                    @csrf
                                    <input name="productId" type="hidden" value="{{ $product->id }}">
                                    Quantity: <input type="number" name="quantity" class="{{ $errors->has('quantity') ? ' border-danger' : '' }}">
                                    <small class="form-text text-danger">{!! $errors->first('quantity') !!}</small>
                                    <br>
                                    <input type="submit" value="Add to Cart">
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection