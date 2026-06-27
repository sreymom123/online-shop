@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="oh-page-title">Order #{{ $order->id }}</h1>
    <p class="oh-page-sub">Order details and item breakdown.</p>
</div>

<div class="oh-detail-card mb-4">
    <div class="oh-detail-grid">
        <div class="oh-detail-item">
            <div class="oh-detail-label">Customer</div>
            <div class="oh-detail-value">{{ $order->user->name }}</div>
        </div>
        <div class="oh-detail-item">
            <div class="oh-detail-label">Email</div>
            <div class="oh-detail-value">{{ $order->user->email }}</div>
        </div>
        <div class="oh-detail-item">
            <div class="oh-detail-label">Total</div>
            <div class="oh-detail-value oh-price">${{ $order->total_amount }}</div>
        </div>
        <div class="oh-detail-item">
            <div class="oh-detail-label">Status</div>
            <div class="oh-detail-value">
                @if($order->status == 'pending')
                    <span class="oh-badge oh-badge-pending">● PENDING</span>
                @elseif($order->status == 'processing')
                    <span class="oh-badge oh-badge-processing">● PROCESSING</span>
                @elseif($order->status == 'completed')
                    <span class="oh-badge oh-badge-completed">● COMPLETED</span>
                @else
                    <span class="oh-badge oh-badge-cancelled">● CANCELLED</span>
                @endif
            </div>
        </div>
        <div class="oh-detail-item">
            <div class="oh-detail-label">Address</div>
            <div class="oh-detail-value">{{ $order->address }}</div>
        </div>
        <div class="oh-detail-item">
            <div class="oh-detail-label">Date</div>
            <div class="oh-detail-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</div>

<div class="oh-section-title">Order Items</div>
<div class="oh-table-wrap mb-4">
    <table class="oh-table">
        <thead>
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
                <td class="oh-product-name">{{ $item->product->name }}</td>
                <td class="oh-td-muted">${{ $item->price }}</td>
                <td class="oh-td-muted">{{ $item->quantity }}</td>
                <td class="oh-price">${{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="{{ route('admin.orders.index') }}" class="oh-btn-secondary">← Back to Orders</a>

<style>
.oh-page-title  { font-size: 24px; font-weight: 700; color: #1a2e1f; letter-spacing: -.4px; margin: 0 0 2px; }
.oh-page-sub    { font-size: 12.5px; color: #7a8c80; margin: 0; }
.oh-section-title { font-size: 14px; font-weight: 600; color: #1a2e1f; margin-bottom: 10px; }

.oh-detail-card {
    background: #fff;
    border: 1px solid #e2e6de;
    border-radius: 14px;
    padding: 24px;
}
.oh-detail-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
.oh-detail-label { font-size: 11px; font-weight: 600; color: #7a8c80; text-transform: uppercase; letter-spacing: .7px; margin-bottom: 5px; }
.oh-detail-value { font-size: 14px; color: #1a2e1f; font-weight: 500; }

.oh-price { font-weight: 700; color: #1a2e1f; }

.oh-badge {
    display: inline-flex; align-items: center;
    font-size: 10px; font-weight: 700;
    letter-spacing: .5px;
    padding: 4px 10px; border-radius: 99px;
}
.oh-badge-pending   { background: #fef9e6; color: #8a6a00; border: 1px solid #f0d060; }
.oh-badge-processing{ background: #e6f0fe; color: #1a4a8a; border: 1px solid #a0c0f0; }
.oh-badge-completed { background: #e6f4ec; color: #1e5234; border: 1px solid #a0d4b0; }
.oh-badge-cancelled { background: #fdf0f0; color: #8a2020; border: 1px solid #f5c0c0; }

.oh-table-wrap {
    background: #fff;
    border: 1px solid #e2e6de;
    border-radius: 14px;
    overflow: hidden;
}
.oh-table { width: 100%; border-collapse: collapse; }
.oh-table thead tr { border-bottom: 1px solid #e2e6de; }
.oh-table thead th {
    padding: 11px 16px;
    font-size: 10.5px; font-weight: 600;
    letter-spacing: .8px; text-transform: uppercase;
    color: #7a8c80; background: #fff; text-align: left;
}
.oh-table tbody tr { border-bottom: 1px solid #f0f2ee; transition: background .12s; }
.oh-table tbody tr:last-child { border-bottom: none; }
.oh-table tbody tr:hover { background: #fafbf8; }
.oh-table tbody td { padding: 13px 16px; font-size: 13.5px; color: #1a2e1f; vertical-align: middle; }
.oh-td-muted { color: #7a8c80 !important; font-size: 13px !important; }
.oh-product-name { font-weight: 600; }

.oh-btn-secondary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 99px;
    background: transparent; color: #5a7a65;
    font-size: 13px; font-weight: 600;
    border: 1px solid #e2e6de; text-decoration: none;
    transition: background .15s;
}
.oh-btn-secondary:hover { background: #f0f2ee; color: #1e3a2b; }

@media (max-width: 768px) {
    .oh-detail-grid { grid-template-columns: 1fr 1fr; }
}
</style>
@endsection
