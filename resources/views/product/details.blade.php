@extends('layouts.app')

@section('content')
<div class="container">


        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <img class="img-fluid" src="{{ $product->image }}" alt="">
                    </div>
                    <div class="col-md-6">
                        <h3 class="card-title">{{ $product->title }}</h3>
                        <h4>₱{{ number_format($product->price, 2) }}</h4>
                        <p class="card-text">{{ $product->description }}</p>

                        <button class="btn btn-primary btn-sm">
                            <a href="/cart/AddItem?id={{ $product->id }}">Add to cart</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Product Reviews
            </div>
            <div class="card-body">
                @foreach($product->reviews as $review)
                    <p class="mb-2">{{  $review->message }}</p>
                    <small class="text-muted">Posted by {{ $review->user->name}} on {{ $review->created_at->toFormattedDateString() }}</small>
                    <hr>
                @endforeach
                @if(auth()->check())
                    @if (session('status') || session('message'))
                        <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger'}}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form action="{{ route('product.review', $product->id) }}" method="POST">
                        <div class="form-group">
                            <label for="">Message</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="3" placeholder="leave a review"></textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            @csrf
                            <button class="btn btn-success btn-sm">Submit</button>
                        </div>
                    </form>
                @else
                    <h4>Leave a Review</h4>
                    You need to login first
                @endif
            </div>
        </div>


      </div>
@endsection
