@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 p-1">
            <div class="card">
                <div class="card-header">CART DASHBOARD</div>
                <div class="card-body">
                    <div id="mainDashboard" class="row justify-content-center">
                     @if(isset($cart_count) && $cart_count != 0)
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
                                                    <a href="{{ route('cart.delete', $cart->id) }}"><i class="fas fa-trash-alt"></i></a>
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
                                                <div class="col-6"><h5>Shipping cost</h5></div>
                                                <div class="col-6 text-right"><h5 style="color: #f6ff00">₱{{ count($carts) != 0 ? '100' : '0' }}</h5></div>
                                                <div class="col-6"><h2>Total cost</h2></div>
                                                <div class="col-6 text-right"><h2 style="color: #f6ff00" id="totalPrice">₱0</h2></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputLocation">Address</label>
                                            <select class="form-control" name="address">
                                                @foreach ($addresses as $address)
                                                    <option value="{{ $address->id }}">{{ $address->full_address }}</option>
                                                @endforeach
                                            </select>
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your location with anyone else.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputPaymentOption">Payment Type</label>
                                            <select class="form-control" name="payment_method">
                                                <option value="1">Cash On Delivery</option>
                                                <option value="2">Paypal</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-2">Checkout</button>
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
                            <a class="btn btn-info btn-lg btn-block my-1" href="/">Order Now</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(function($) {
        var total = 0;
        $('input[type=number]').each(function (index, value) {
            var curThis = $(this);
            total = total + curThis.data('total');
        });
        if(total == 0){
            $('#totalPrice').html("₱" + total);
        }else{
            total = parseInt(total) + 100;
            $('#totalPrice').html("₱" + total);
        }

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
            total = parseInt(total) + 100;

            $('#totalPrice').html("₱" + total);
        });


        var payment_method =  $('select[name="payment_method"]').val()
        var address = $('select[name="address"]').val()

        $('select[name="payment_method"]').change(function(){
            payment_method = $(this).val();
        })
        $('select[name="address"]').change(function(){
            address = $(this).val();
        })

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
                payment_method: payment_method,
                address: address,
                product_ids: product_ids,
                product_quantities: product_quantities,
                total_price: total,
            },function(data){
                console.log(data);

                $('#mainDashboard').html('<div class="col-12"><div class="alert alert-warning" role="alert">Redirecting.. Please wait</div></div>');
                if(data.status){
                    setTimeout(function(){
                        window.location.href = data.redirect_url
                    }, 2000);
                }else{
                    alert(data.message);
                    window.location.reload();
                }
            });
        });
    });
</script>
@endsection
