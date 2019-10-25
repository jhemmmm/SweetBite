@extends('layouts.setting')

@section('content')
    <div class="card">
        <div class="card-header">
            Add new Address
        </div>
        <div class="card-body">
            <form action="{{ route('user.addresses.store') }}" method="POST">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" placeholder="09124578965" value="{{ old('mobile_number') }}">
                        @error('mobile_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                    <div class="form-group">
                    <label for="">House Number</label>
                    <input type="text" name="house_number" class="form-control @error('house_number') is-invalid @enderror" value="{{ old('house_number') }}">
                    @error('house_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Barangay</label>
                    <input type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror" value="{{ old('barangay') }}">
                    @error('barangay')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">City</label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Province</label>
                        <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province') }}">
                        @error('province')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="float-right">
                        @csrf
                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection