@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">

    </div>
    <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
            <img class="d-block img-fluid" src="/images/slider/1.png" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block img-fluid" src="/images/slider/2.png" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block img-fluid" src="/images/slider/3.png" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
    {{-- <div class="row justify-content-center"> --}}
    <div class="row">

        @foreach($products as $product)
        {{-- <div class="col-sm-12 col-lg-6 p-1">
            <div class="gallery">
                <div class="image">
                    <img src="{{ $product->image }}" />
                </div>
                <div class="details">
                    <h1>{{ $product->title }}</h1>
                    <p>{{ $product->discreption }}</p>
                    <h3>₱{{ $product->price }}</h3>
                    <button class="btn btn-primary">
                        <a href="/cart/AddItem?id={{ $product->id }}">ORDER NOW</a>
                    </button>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <a href="{{ route('product.view', $product->id) }}"><img class="card-img-top img-fluid" src="{{ $product->image }}" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ route('product.view', $product->id) }}">{{ $product->title }}</a>
                    </h4>
                    <h5>₱{{ number_format($product->price, 2) }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                </div>
                <div class="card-footer">
                    <a href="/cart/AddItem?id={{ $product->id }}" class="btn btn-primary btn-sm">Add to cart</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(count($products) == 0)
        <div class="text-center my-5">
            <h1>No Products Found</h1>
        </div>
    @endif
</div>
@endsection
