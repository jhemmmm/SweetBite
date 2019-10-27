@extends('layouts.app')


@section('content')
<div class="container">
    <div class="text-center">
        <div class="alert alert-success">
            {{ $message }}
            <br> Redirecting...
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        setTimeout(function(){
            window.location.href = '/user/orders/{{ $order->id }}'
        }, 2000)
    });

</script>
@endsection
