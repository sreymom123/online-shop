@extends('admin.layouts.app')

@section('content')
<div class="mb-2">
    <h1 class="oh-page-title">Orders</h1>
    <p class="oh-page-sub">Manage your daily transaction logs and farm-to-table deliveries.</p>
</div>

<div class="oh-table-wrap">
    <table class="oh-table">
        <thead>
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
                <td class="oh-td-muted">{{ $order->id }}</td>
                <td>
                    <div class="oh-customer-cell">
                        <div class="oh-customer-av">{{ strtoupper(substr($order->user->name, 0, 1)) }}</div>
                        <span class="oh-customer-name">{{ $order->user->name }}</span>
                    </div>
                </td>
                <td class="oh-price">${{ $order->total_amount }}</td>
                <td>
                    @if($order->status == 'pending')
                        <span class="oh-badge oh-badge-pending">● PENDING</span>
                    @elseif($order->status == 'processing')
                        <span class="oh-badge oh-badge-processing">● PROCESSING</span>
                    @elseif($order->status == 'completed')
                        <span class="oh-badge oh-badge-completed">● COMPLETED</span>
                    @else
                        <span class="oh-badge oh-badge-cancelled">● CANCELLED</span>
                    @endif
                </td>
                <td class="oh-td-muted">{{ $order->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="oh-btn-view">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="oh-table-footer">
        Showing {{ $orders->count() }} orders
    </div>
</div>

<style>
.oh-page-title { font-size: 24px; font-weight: 700; color: #1a2e1f; letter-spacing: -.4px; margin: 0 0 2px; }
.oh-page-sub   { font-size: 12.5px; color: #7a8c80; margin: 0; }

.oh-table-wrap {
    background: #fff;
    border: 1px solid #e2e6de;
    border-radius: 14px;
    overflow: hidden;
    margin-top: 16px;
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

.oh-customer-cell { display: flex; align-items: center; gap: 9px; }
.oh-customer-av {
    width: 28px; height: 28px; border-radius: 50%;
    background: #e6f4ec; color: #1e5234;
    font-size: 11px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.oh-customer-name { font-weight: 600; color: #1a2e1f; }

.oh-price { font-weight: 600; color: #1a2e1f; }

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

.oh-btn-view {
    display: inline-flex; align-items: center;
    padding: 5px 14px; border-radius: 8px;
    background: #1e3a2b; color: #fff;
    border: 1px solid #1e3a2b;
    font-size: 12px; font-weight: 500;
    text-decoration: none; transition: background .15s;
}
.oh-btn-view:hover { background: #2d5a3d; color: #fff; }

.oh-table-footer {
    padding: 10px 16px;
    font-size: 11.5px; color: #7a8c80;
    border-top: 1px solid #f0f2ee;
}
</style>
@endsection
