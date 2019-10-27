@extends('layouts.admin')


@section('content')

    <div class="card-body">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">Invoice Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">Payment Method</td>
                            <td>
                                {{ $invoice->order->payment }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Transaction ID</td>
                            <td>
                                {{ $invoice->transaction_id }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Amount</td>
                            <td>
                                {{ number_format($invoice->order->paid_price, 2) }}
                            </td>
                        </tr>
                        @if($invoice->status == 2 || $invoice->status == 3)
                        <tr>
                            <td scope="row">Status</td>
                            <td class="text-danger">
                                <b>{{ $invoice->status == 2 ? 'Refunded' : 'Cancelled' }}</b>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">Customer Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">Full Name</td>
                            <td>
                                {{ $invoice->order->address->name }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Email</td>
                            <td>
                                {{ $invoice->order->user->email }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Mobile Number</td>
                            <td>
                                {{ $invoice->order->address->mobile_number }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{-- <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">Ticket Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ticket = $invoice->ticket;
                            $trip = $ticket->trip;
                            $routes = $trip->routes->where('type', 0)->first();
                            $terminal = $routes->terminal;
                        @endphp
                        <tr>
                            <td scope="row" width="40%">Ticket Number</td>
                            <td>
                                {{ $ticket->ticket_no }}
                            </td>
                        </tr>

                        <tr>
                            <td scope="row" width="40%">Boarding Point</td>
                            <td>
                                {{ $terminal->name }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row" width="40%">Dropping Point</td>
                            <td>
                                {{ $invoice->ticket->route->terminal->name }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Reserved Seats</td>
                            <td>
                                {{ implode($invoice->ticket->reserved_seats, ',') }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Amount</td>
                            <td>
                                PHP {{ number_format($invoice->ticket->amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Status</td>
                            <td>
                                {{ $ticket->ticket_status }}
                            </td>
                        </tr>
                    </tbody>
                </table> --}}
            </div>
        </div>
    </div>

@endsection
