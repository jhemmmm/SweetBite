@extends('layouts.app')

@section('cart')
<a href="/cart"><i class="fas fa-shopping-cart"></i> ({{ (isset($cart_count)) ? $cart_count : 0 }})</a>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
    
    </div>
    <div class="row justify-content-center">

        @foreach($products as $product)
        <div class="col-sm-12 col-lg-6 p-1">
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
        </div>
        @endforeach

    </div>

</div>
@endsection
