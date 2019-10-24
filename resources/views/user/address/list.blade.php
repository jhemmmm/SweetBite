@extends('layouts.setting')

@section('content')
    <div class="card">
        <div class="card-header">
            Addresses
        </div>
        <div class="card-body">
            @if (session('status') || session('message'))
                <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger'}} mb-3">
                    {{ session('message') }}
                </div>
            @endif
            <div class="float-right">
                <a href="{{ route('user.addresses.create') }}" class="btn btn-secondary btn-sm">Add New Address</a>
            </div>
            <div class="clearfix"></div>
            @foreach ($addreses as $address)
                <address class="mx-3">
                    <strong>{{ $address->name }}</strong><br>
                    {{ $address->house_number . ', ' . $address->barangay }}<br>
                    {{ $address->city .', ' .$address->province}}<br>
                    <abbr title="Phone">P:</abbr> {{ $address->mobile_number }}
                    <div class="mt-2">
                        <a href="{{ route('user.addresses.edit', $address->id) }}">Edit</a> -
                        <a href="{{ route('user.addresses.delete', $address->id) }}" onclick="event.preventDefault();
                        confirm('Are you sure you want to delete this address?')
                        document.getElementById('delete-form{{ $address->id }}').submit();">Delete</a>
                    </div>
                </address>
                <form id="delete-form{{ $address->id }}" action="{{ route('user.addresses.delete', $address->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>
@endsection
