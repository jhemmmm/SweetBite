@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Product Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">Name</td>
                                    <td>
                                        {{ $product->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">Quantity</td>
                                    <td>
                                        {{ $product->quantity }}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">Price</td>
                                    <td>
                                        ₱{{ number_format($product->price, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <h3 class="card-title">Ordered Product History</h3>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>OrderID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->orderProducts as $order)
                            <tr>
                                <td scope="row">
                                    {{ $product->title }}
                                </td>
                                <td>
                                    {{ $order->ordered_quantity }}
                                </td>
                                <td>
                                    ₱{{ number_format($product->price, 2) }}
                                </td>
                                <td>
                                    ₱{{ number_format(($order->ordered_quantity * $product->price), 2)}}
                                </td>
                                <td>
                                    #{{ $order->order_id }}
                                    {{-- <a href="{{ route('admin.order.view', $order->order_id) }}" class="btn btn-sm btn-primary">Order #{{ $order->order_id }}</a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
