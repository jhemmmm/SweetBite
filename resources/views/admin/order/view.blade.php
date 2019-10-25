@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-body">
            @if (session('status') || session('message'))
                <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger'}}">
                    {{ session('message') }}
                </div>
            @endif
            <div class="float-right mb-4">
                <form action="" method="POST">
                    @if($order->status == 2)
                        <input type="hidden" value="deliver" name="status">
                        <button class="btn btn-warning btn-sm">Delivered</button>
                    @elseif($order->status == 3)
                        <input type="hidden" value="shipped" name="status">
                        <button class="btn btn-success btn-sm">Shipped</button>
                    @endif
                    @csrf
                    <a href="{{ route('admin.invoice.view', $order->invoice->id) }}" class="btn btn-info btn-sm">Invoice</a>
                </form>
            </div>
            <h3 class="card-title">Order #{{ $order->id }} Details</h3>
            <div class="clearfix"></div>
            <div class="row">
                    <div class="col-md-6">
                        <address>
                            <strong>{{ $order->address->name }}</strong><br>
                            {{ $order->address->house_number . ', ' . $order->address->barangay }}<br>
                            {{ $order->address->city .', ' .$order->address->province}}<br>
                            <abbr title="Phone">P:</abbr> {{ $order->address->mobile_number }}
                        </address>
                    </div>
                    <div class="col-md-6">
                        Payment Method: <b>{{ $order->payment }}</b> <br>
                        {{-- Total: {{ number_format($total + 50, 2) }} <br> --}}
                        Status: <b>{{ $order->status_type }}</b>
                    </div>
                </div>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td scope="row">
                                    {{ $product->title }}
                                </td>
                                <td>
                                    {{ $product->pivot->ordered_quantity }}
                                </td>
                                <td>
                                    {{ number_format($product->price, 2) }}
                                </td>
                                <td>
                                    {{ number_format(($product->pivot->ordered_quantity * $product->price), 2)}}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right"><b>Delivery Fee:</b></td>
                            <td>{{ number_format(50, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><b>Grand Total:</b></td>
                            <td>{{ number_format($order->paid_price + 50, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
   
@endsection