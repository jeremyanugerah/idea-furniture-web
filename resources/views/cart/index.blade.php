@extends('layouts.app')

@section('content')
<div class="big-container" style="background-color: #f5d7b5;min-height: 100vh; padding: 40px 100px 40px 100px;">
    <div class="container-fluid rounded" style="background:white; min-height: 30vh; padding:30px 70px 30px 70px;">
    <div class="title-container" style="text-align: center; margin: 0;">
            <h2 style="padding: 0; margin-bottom: 25px;">Shopping Cart</h2>
    </div>

        @if (count($cartItems) == 0)
            There are no items in the shopping cart
        @else
            {{-- Initialize grand total variable --}}
            @php($grandTotal = 0)
            
            @foreach ($cartItems as $cartItem)
                <div class="row" style="padding: 0; margin: 0; margin-bottom: 20px; background-color: rgba(243, 241, 239, 1);"> 
                    <div class="col" style="padding:20px;">
                        <img src="{{ $cartItem->product->image }}" class="card-img-top" alt="" style ="width: 200px; height: 200px;">
                    </div> 
                    <div class="col d-flex flex-column justify-content-center">
                        <span class="detail-title">Product Name:</span>
                        <h5 class="detail-text">{{ $cartItem->product->name }}</h5>
                    </div> 
                    <div class="col d-flex flex-column justify-content-center">
                        <span class="detail-title">Quantity:</span>
                        <form action="/cartItem/update-cart" method="POST" class="quantity-form d-flex flex-row">
                            @csrf
                            &nbsp;
                            <input class="invisible" type="hidden" type="number" name="product_id" value="{{ $cartItem->product_id }}">
                            <input class="form-control" style="width: 120px; border-color: black;" type="number" name="quantity" value="{{ $cartItem->quantity }}">
                            <input class="form-control btn btn-outline-dark" type="submit" value="&#10003;">
                        </form>

                    </div> 
                    <div class="col d-flex flex-column justify-content-center">
                        <span class="detail-title">Price:</span>
                        <h5 class="detail-text">Rp {{ number_format($cartItem->product->price, 0, ",", ".") }}</h5>
                    </div> 
                    <div class="col d-flex flex-column justify-content-center">
                        <span class="detail-title">SubTotal:</span>
                        <h5 class="detail-text">Rp {{ number_format($cartItem->product->price * $cartItem->quantity, 0, ",", ".") }}</h5>
                    </div> 
                    <div class="col d-flex flex-column justify-content-center text-center">
                        <form action="/cartItem/destroy" method="POST">
                            @csrf
                            <input class="invisible" type="hidden" type="number" name="product_id" value="{{ $cartItem->product_id }}">
                            <input class="btn btn-outline-dark" type="submit" value="&#10005;">
                        </form>
                    </div> 
                </div> 
                {{-- Calculate the grand total --}}
                @php($grandTotal = $grandTotal + $cartItem->product->price * $cartItem->quantity)
            @endforeach

            <div class="bottom-container d-flex justify-content-between">
                <h5>Grand Total: {{ number_format($grandTotal, 0, ",", ".") }}</h5>
                <form action="/transaction/checkout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark">Checkout</button>
                </form>
            </div>
        @endif
        </div>    
</div>

@endsection