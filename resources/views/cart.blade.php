@extends('layouts.app')

@section('cart')
<a href="/cart"><i class="fas fa-shopping-cart"></i> ({{ (isset($cart_count)) ? $cart_count : 0 }})</a>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 p-1">
            <div class="card">
                <div class="card-header">CART DASHBOARD</div>
                <div class="card-body">
                    <div id="mainDashboard" class="row justify-content-center">
                     @if(isset($cart_count))
                        <!--- Left Side -->
                        <div class="col-12 col-md-8">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="col">#</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($carts as $cart)
                                            <tr>
                                                <th scope="row">
                                                    <img src="{{ $cart->product->image }}" style="width: 60px;height: 60px;">
                                                    <label style="padding-left: 10px;">{{ $cart->product->title }}</label>
                                                    </th>
                                                <td>
                                                    <h3>₱{{ $cart->product->price }}</h3><br>
                                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                                <td><input type="number" data-id="{{ $cart->product->id }}" data-price="{{ $cart->product->price }}" data-total="{{ $cart->quantity * $cart->product->price }}" value="{{ $cart->quantity }}" min="1" max="10" step="1"/></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--- Right Side -->
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-header">ORDER SUMMARY</div>
                                <div class="card-body">
                                    <form id="checkoutForm" action="/cart/OrderItem" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-6"><h2>Total cost</h2></div>
                                                <div class="col-6 text-right"><h2 style="color: #f6ff00" id="totalPrice">₱0</h2></div>
                                                <script>
                                                jQuery(function($) {
                                                    var total = 0;
                                                    $('input[type=number]').each(function (index, value) {
                                                        var curThis = $(this);
                                                        total = total + curThis.data('total');
                                                    });
                                                    $('#totalPrice').html("₱" + total);

                                                    $('input[type=number]').on('input', function() {
                                                        var curThis = $(this);
                                                        var quantity = curThis.val();
                                                        var price = curThis.data('price');
                                                        curThis.data('total', quantity * price);

                                                        total = 0;
                                                        $('input[type=number]').each(function (index, value) {
                                                            var curThis = $(this);
                                                            total = total + curThis.data('total');
                                                        });
                                                        $('#totalPrice').html("₱" + total);
                                                    });

                                                    $( "#checkoutForm" ).submit(function( event ) {
                                                        event.preventDefault();
                                                       
                                                        var product_ids = [];
                                                        var product_quantities = [];
                                                        $('input[type=number]').each(function (index, value) {
                                                            var curThis = $(this);
                                                            var id = curThis.data('id');
                                                            var quantity = curThis.val();
                                                            product_ids.push(id);
                                                            product_quantities.push(quantity);
                                                        });
                                                        
                                                        $('#mainDashboard').html('<div class="loader"></div>');

                                                        $.post("/cart/OrderItem",{
                                                            product_ids: product_ids,
                                                            product_quantities: product_quantities,
                                                            total_price: total,
                                                        },function(data){
                                                                $('#mainDashboard').html('<div class="col-12"><div class="alert alert-success" role="alert">Success</div></div>');
                                                            });
                                                        });
                                                });

                                                
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputLocation">Location</label>
                                            <select class="form-control">
                                                <option value="volvo">Philiphines</option>
                                                <option value="saab">Saab</option>
                                                <option value="mercedes">Mercedes</option>
                                                <option value="audi">Audi</option>
                                            </select>
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your location with anyone else.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputPaymentOption">Payment Type</label>
                                            <select class="form-control">
                                                <option value="cod">Cash On Delivery</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block">CHECK OUT</button>
                                        <a class="btn btn-info btn-lg btn-block my-1" href="/">ORDER MORE</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                You have 0 items in your cart!
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
