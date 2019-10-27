@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Products
        <div class="float-right">
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm">Create</a>
        </div>
    </div>
    <hr class="my-2"/>
    @if (session('status') || session('message'))
        <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger'}}">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        {{-- <div class="card-header">
            <h3 class="card-title">Order History</h3>
        </div> --}}
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>₱{{ number_format($product->price, 2)  }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.product.delete', $product->id) }}">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.product.update', $product->id) }}">Update</a>
                                    <button class="btn btn-danger btn-sm"  onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($products->total() == 0)
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
    {{ $products }}
@endsection
