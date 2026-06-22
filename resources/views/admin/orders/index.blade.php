@extends('admin.layouts.app')

@section('content')
<h2>Orders</h2>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>${{ $order->total_amount }}</td>
            <td>
                @if($order->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($order->status == 'processing')
                    <span class="badge bg-info">Processing</span>
                @elseif($order->status == 'completed')
                    <span class="badge bg-success">Completed</span>
                @else
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </td>
            <td>{{ $order->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order) }}"
                   class="btn btn-sm btn-info">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection