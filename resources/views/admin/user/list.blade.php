@extends('layouts.admin')

@section('content')
    <h2 class="page-title mb-2">Users</h2>
    <hr class="mt-2"/>
    <table class="table">
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
                            <button class="btn btn-danger btn-sm"  onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                        </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection