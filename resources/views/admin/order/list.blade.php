@extends('layouts.admin')

@section('content')
   <table class="table">
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
               <td>{{ $order->user->name }}</td>
               <td>
                  <a href="" class="btn btn-primary btn-sm">View</a>
               </td>
            </tr>
         @endforeach
      </tbody>
   </table>
@endsection