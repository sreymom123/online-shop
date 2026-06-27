@extends('admin.layouts.app')

@section('content')
<div class="oh-page-header">
    <h1 class="oh-page-title">Dashboard</h1>
    <p class="oh-page-sub">Welcome back to your harvest command center.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="oh-stat-card">
            <div class="oh-stat-top">
                <div class="oh-stat-icon"><i class="bi bi-people"></i></div>
                <span class="oh-badge oh-badge-up">↑ 12%</span>
            </div>
            <div class="oh-stat-label">Total Users</div>
            <div class="oh-stat-num">{{ $totalUsers }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="oh-stat-card">
            <div class="oh-stat-top">
                <div class="oh-stat-icon"><i class="bi bi-box"></i></div>
                <span class="oh-badge oh-badge-inv">INVENTORY</span>
            </div>
            <div class="oh-stat-label">Total Products</div>
            <div class="oh-stat-num">{{ $totalProducts }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="oh-stat-card">
            <div class="oh-stat-top">
                <div class="oh-stat-icon"><i class="bi bi-cart"></i></div>
                <span class="oh-badge oh-badge-hi">↗ HIGH</span>
            </div>
            <div class="oh-stat-label">Total Orders</div>
            <div class="oh-stat-num">{{ $totalOrders }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="oh-stat-card oh-stat-card--dark">
            <div class="oh-stat-top">
                <div class="oh-stat-icon oh-stat-icon--dark"><i class="bi bi-cash-stack"></i></div>
                <span class="oh-badge oh-badge-pend">PENDING</span>
            </div>
            <div class="oh-stat-label oh-stat-label--dark">Total Revenue</div>
            <div class="oh-stat-num oh-stat-num--dark">${{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>
</div>

<style>
.oh-page-header  { margin-bottom: 22px; }
.oh-page-title   { font-size: 26px; font-weight: 700; color: #1a2e1f; letter-spacing: -.5px; margin: 0 0 2px; }
.oh-page-sub     { font-size: 13px; color: #7a8c80; margin: 0; }

.oh-stat-card {
    background: #fff;
    border: 1px solid #e2e6de;
    border-radius: 14px;
    padding: 16px;
    height: 100%;
}
.oh-stat-card--dark { background: #1e3a2b; border-color: #1e3a2b; }

.oh-stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }

.oh-stat-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: #f0f0e8;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #7a8c80;
}
.oh-stat-icon--dark { background: rgba(255,255,255,.15); color: #fff; }

.oh-badge {
    font-size: 9.5px; font-weight: 600;
    border-radius: 99px; padding: 3px 8px;
    letter-spacing: .3px;
}
.oh-badge-up   { background: #e4f5e8; color: #276b36; }
.oh-badge-inv  { background: #e2eef8; color: #1e5278; }
.oh-badge-hi   { background: #fef3e2; color: #8a5a10; }
.oh-badge-pend { background: rgba(255,255,255,.18); color: #fff; }

.oh-stat-label       { font-size: 11px; color: #7a8c80; margin-bottom: 4px; }
.oh-stat-label--dark { color: rgba(255,255,255,.7); }
.oh-stat-num         { font-size: 28px; font-weight: 700; color: #1a2e1f; letter-spacing: -1px; }
.oh-stat-num--dark   { color: #fff; }
</style>
@endsection
