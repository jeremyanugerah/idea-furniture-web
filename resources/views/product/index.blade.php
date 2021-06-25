@extends('layouts.app')
@section('style')
    <style>
    .pagination > li > a
    {
        background-color: white;
        color: brown;
    }
    .pagination > li > a:focus,
    .pagination > li > a:hover,
    .pagination > li > span:focus,
    .pagination > li > span:hover
    {
        color: brown;
        background-color: #eee;
        border-color: #ddd;
    }

    .pagination > .active > a
    {
        color: white;
        background-color: brown;
        border: solid 1px brown;
    }

    .pagination > .active > a:hover
    {
        background-color: brown;
        border: solid 1px brown;
    }

    .page-item.active .page-link {
        color: #fff;
        background-color: brown;
        border-color: brown;
    }

    </style>
@endsection

@section('content')
<div class="big-container" style="background-color: #f5d7b5; padding: 40px; min-height: 100vh;">
            <div class="container rounded" style="background:rgba(255,255,255, 0.9); padding: 40px; min-height: 30vh;">
            <div class="title-container" style="text-align: center;">
                <h2 class="mb-2 mt-3" style="color: #654321;">{{ $productType->name }}</h2>
            </div>
            <div class="search-container mb-3">
                <form action="" method = "get">
                  <input class="btn btn-sm btn-outline-dark disabled" style="border-color: brown" type="text" placeholder="Search product..." name="search">
                  <input class="btn btn-sm btn-outline-dark" style="border-color: brown" type="submit" value="search">
                </form>
            </div>

            @if (strlen($search) > 0)
                    <h6>Search result for: {{ $search }}</h6>
            @endif

            @if ($products->count() == 0)
                <h6 class="mb-2 mt-3">No result found</h6>
            @else
                @foreach ($products as $product)
                    @if (($loop->iteration -1) % 4 == 0)
                        <div class="row m-0 justify-content-start">
                    @endif
                        <div class="col-3" style="padding: 0;">
                                <div class="card text-center shadow-sm border-0" style="border-radius: 0; width: 100%; padding: 20px;">

                                <a href="/product/{{ $product->id }}">
                                    <img src="{{$product->image}}" onerror="this.onerror=null;this.src='/storage/images/noimage.png';" class="card-img-top" style="width: 180px; height: 180px"alt="...">
                                </a>

                                <div class="card-body">
                                    <a class="nav-link p-0" style="color: brown" href="/product/{{ $product->id }}"><h5 class="card-title">{{ $product->name }}</h5></a>
                                    <div class="container mb-3" style="height: 7vh; padding: 0px;">
                                            <p class="card-text">{{ $product->description }}</p>
                                    </div>
                                    <h4 class="card-price mb-3">Rp {{ number_format("$product->price", 0, ",", ".") }}</h4>

                                    @auth
                                        @if(Auth::user()->role == 'admin')
                                            <a class="btn btn-outline-primary" style="display: inline-block;" href="/product/{{ $product->id }}/edit">Update</a>
                                            <form class="" style="display: inline-block;" action="/product/{{ $product->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <input class="btn btn-outline-danger" type="submit" value="Delete">
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @if ($loop->index != 0 and $loop->iteration % 4 == 0)
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        <nav aria-label="...">
        <ul class="pagination pagination-lg">
            {{ $products->withQueryString()->links() }}
        </ul>
</nav>
        <br>
    </div>
@endsection