@extends('layouts.admin')

@section('content')

    {{-- <h2 class="page-title mb-2">Order History</h2>
    <hr class="mt-2"/> --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order History</h3>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>₱{{ number_format($order->paid_price, 2) }}</td>
                        <td>{{ $order->status_type }}</td>
                        <td>
                            <a href="{{ route('admin.order.view', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                        </td>
                        </tr>
                    @endforeach
                    @if($orders->total() == 0)
                        <tr>
                            <td colspan="4" class="text-center">
                                No Result found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $orders }}
        </div>
    </div>
@endsection
