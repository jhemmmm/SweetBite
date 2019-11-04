@extends('layouts.admin')

@section('content')
<h2 class="page-title mb-2">Dashboard</h2>
<hr class="mt-2" />

<div class="row">
    <div class="col-sm-6 col-xl-4">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-blue mr-3">
                    <i class="fa fa-table"></i>
                </span>
                <div>
                    <h4 class="m-0">
                        {{ $orders->total() }}
                        <small>Total Orders</small>
                    </h4>
                    <small class="text-muted">{{ $shipped }} shipped</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-blue mr-3">
                    <i class="fa fa-dollar-sign"></i>
                </span>
                <div>
                    <h4 class="m-0">
                        ₱ {{ $dailyEarnings->total_amount ?? 0 }}
                        <small>Daily Earning</small>
                    </h4>
                    <small class="text-muted">{{ $pendingPayments }} waiting payments</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-blue mr-3">
                    <i class="fa fa-ban"></i>
                </span>
                <div>
                    <h4 class="m-0">
                        {{ $cancelled }}
                        <small>Cancelled Orders</small>
                    </h4>
                    <small class="text-muted">{{ $refunded }} refund orders</small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Processing Orders</h3>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user ? $order->user->name : '-' }}</td>
                    <td>₱{{ number_format($order->paid_price, 2) }}</td>
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
