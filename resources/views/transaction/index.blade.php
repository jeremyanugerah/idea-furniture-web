@extends('layouts.app')

@section('content') 
<div class="big-container" style="background-color: #f5d7b5;min-height: 100vh; padding: 40px 100px 40px 100px;">
    <div class="container-fluid rounded" style="background:white; min-height: 30vh; padding:30px 70px 30px 70px;">
        <div class="title-container" style="text-align: center; margin: 0;">
            <h2>Transaction History</h2>
        </div>

        @if (count($transactions) == 0)
            There are no transactions
        @else
            @foreach ($transactions as $transaction)
                <hr>
                <h5>{{ $transaction->date_time->format('l\, d F Y \a\t H:i:s') }}</h5>

                {{-- Initialize grand total variable --}}
                @php($grandTotal = 0)

                @foreach ($transaction->transactionDetails as $transactionDetail)
                    <div class="row" style="padding: 0; margin: 0; margin-bottom: 20px; background-color: rgba(243, 241, 239, 1);"> 
                            <div class="col" style="padding:20px;">
                                <img src="{{ $transactionDetail->product->image }}" class="card-img-top" alt="" style ="width: 200px; height: 200px;">
                            </div> 
                            <div class="col d-flex flex-column justify-content-center">
                                <span class="detail-title">Product Name:</span>
                                <h5 class="detail-text">{{ $transactionDetail->product->name }}</h5>
                            </div> 
                            <div class="col d-flex flex-column justify-content-center">
                                <span class="detail-title">Quantity:</span>
                                <h5 class="detail-text">{{ $transactionDetail->quantity }}</h5>
                            </div> 
                            <div class="col d-flex flex-column justify-content-center">
                                <span class="detail-title">Price:</span>
                                <h5 class="detail-text">Rp {{ number_format($transactionDetail->product->price, 0, ",", ".") }}</h5>
                            </div> 
                            <div class="col d-flex flex-column justify-content-center">
                                <span class="detail-title">SubTotal:</span>
                                <h5 class="detail-text">Rp {{ number_format($transactionDetail->product->price * $transactionDetail->quantity, 0, ",", ".") }}</h5>
                            </div> 
                    </div> 
                    {{-- Calculate the grand total --}}
                    @php($grandTotal = $grandTotal + $transactionDetail->product->price * $transactionDetail->quantity)
                @endforeach

                {{-- Show the grand total in the end --}}
                <div class="container grand-total-container">
                    <h5>Grand Total: {{ number_format($grandTotal, 0, ",", ".") }}</h5>
                </div>
                
                <br>
            @endforeach
        @endif
    </div>
</div>

@endsection