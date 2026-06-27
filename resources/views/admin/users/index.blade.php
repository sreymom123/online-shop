@extends('admin.layouts.app')

@section('content')
<div class="mb-2">
    <h1 class="oh-page-title">Users</h1>
    <p class="oh-page-sub">Manage your registered customers and staff accounts.</p>
</div>

<div class="oh-table-wrap">
    <table class="oh-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Email Address</th>
                <th>Orders</th>
                <th>Joined Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="oh-td-muted">#{{ $user->id }}</td>
                <td>
                    <div class="oh-user-cell">
                        <div class="oh-user-av" style="background: {{ collect(['#d4e8d8','#e8d4d4','#d4d4e8','#e8e4d4','#d4e4e8'])->get($user->id % 5, '#e6f4ec') }}; color: #1e3a2b;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="oh-user-name">{{ $user->name }}</div>
                            @if($user->is_admin ?? false)
                                <span class="oh-staff-badge">STAFF</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="oh-email">{{ $user->email }}</td>
                <td>
                    <span class="oh-orders-pill">{{ $user->orders_count }} {{ $user->orders_count == 1 ? 'Order' : 'Orders' }}</span>
                </td>
                <td class="oh-td-muted">{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="oh-table-footer">
        Showing {{ $users->count() }} users
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

.oh-user-cell { display: flex; align-items: center; gap: 10px; }
.oh-user-av {
    width: 34px; height: 34px; border-radius: 50%;
    font-size: 13px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.oh-user-name  { font-weight: 600; color: #1a2e1f; font-size: 13.5px; }
.oh-staff-badge {
    display: inline-block;
    font-size: 8.5px; font-weight: 700;
    letter-spacing: .8px;
    background: #e8ede8; color: #5a7a65;
    padding: 1px 6px; border-radius: 4px;
    margin-top: 2px;
}

.oh-email { color: #5a7a65 !important; font-size: 13px !important; }

.oh-orders-pill {
    display: inline-block;
    background: #f0f2ee; color: #5a7a65;
    font-size: 11.5px; font-weight: 500;
    padding: 3px 10px; border-radius: 99px;
    border: 1px solid #e2e6de;
}

.oh-table-footer {
    padding: 10px 16px;
    font-size: 11.5px; color: #7a8c80;
    border-top: 1px solid #f0f2ee;
}
</style>
@endsection
