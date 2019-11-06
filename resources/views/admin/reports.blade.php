@extends('layouts.admin')

@section('content')
<h2 class="page-title mb-2">Reports</h2>
<hr class="mt-2" />
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            @if($type == 'orders')
                Daily Orders
            @elseif($type == 'earnings')
                Daily Earnings
            @elseif($type == 'cancelled')
                Cancelled Orders
            @endif
        </h3>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                @if($type == 'orders')
                    <tr>
                        <th>Date</th>
                        <th>Total Orders</th>
                        <th>Total Shipped Orders</th>
                    </tr>
                @elseif($type == 'earnings')
                    <tr>
                        <th>Date</th>
                        <th>Total Income</th>
                    </tr>
                @elseif($type == 'cancelled')
                    <tr>
                        <th>Date</th>
                        <th>Total Cancelled</th>
                        <th>Total Refund</th>
                    </tr>
                @endif
            </thead>
            <tbody>
                @if($type == 'orders')
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{ $report[0]->created_at->toDateString() }} </td>
                            <td>{{ count($report->where('status', 3)) }} </td>
                            <td>{{ count($report->where('status', 2)) }} </td>
                        </tr>
                    @endforeach
                @elseif($type == 'earnings')
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{ $report[0]->created_at->toDateString() }} </td>
                            <td>
                                @php
                                    $total = 0;
                                    foreach($report as $order){
                                        $total += $order->paid_price;
                                    }
                                    echo '₱'.number_format($total,2);
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                @elseif($type == 'cancelled')
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{ $report[0]->created_at->toDateString() }} </td>
                            <td>{{ count($report->where('status', 3)) }} </td>
                            <td>{{ count($report->where('status', 2)) }} </td>
                        </tr>
                    @endforeach
                @endif
                @if(count($reports) == 0)
                    <tr>
                        <td colspan="4" class="text-center">
                            No Result found
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
