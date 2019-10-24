@extends('layouts.setting')

@section('content')
    <div class="card">
        <div class="card-header">
            Order History
        </div>
        <div class="card-body">
            @if (session('status') || session('message'))
                <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger'}} mb-3">
                    {{ session('message') }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td scope="row">
                                {{ $order->id }}
                            </td>
                            <td>
                                {{ number_format($order->paid_price, 2)}}
                            </td>
                            <td>
                                {{ $order->payment_method  == 1 ? 'Cash on Delivery' : 'Paypal'}}
                            </td>
                            <td>
                                {{ $order->status_type }}
                            </td>
                            <td>
                                <a href="{{ route('user.order.view', $order->id) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
