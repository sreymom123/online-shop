@extends('admin.layouts.app')

@section('content')
<h2>Order #{{ $order->id }}</h2>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Customer:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Total:</strong> ${{ $order->total_amount }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
</div>

<h4>Order Items</h4>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>${{ $item->price }}</td>
            <td>{{ $item->quantity }}</td>
            <td>${{ $item->price * $item->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
@endsection