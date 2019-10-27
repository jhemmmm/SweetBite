@extends('layouts.admin')

@section('content')
    {{-- <h2 class="page-title mb-2">Users</h2>
    <hr class="mt-2"/> --}}
    @if (session('status') || session('message'))
        <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger'}}">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users</h3>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.user.delete', $user->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.user.update', $user->id) }}">Update</a>
                                @if($user->id != 1)
                                    <button class="btn btn-danger btn-sm"  onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($users->total() == 0)
                    <tr>
                        <td colspan="4" class="text-center">
                            No Result found
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $users }}
        </div>
    </div>
@endsection
