@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="oh-page-title">Categories</h1>
        <p class="oh-page-sub">Organize and manage your boutique product catalog.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="oh-btn-primary">
        + Add Category
    </a>
</div>

<div class="oh-table-wrap">
    <table class="oh-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td class="oh-td-muted">{{ $category->id }}</td>
                <td>
                    {{ $category->name }}
                </td>
                <td><span class="oh-slug">{{ $category->slug }}</span></td>
                <td class="oh-td-muted">{{ $category->products_count }} SKU</td>
                <td>
                    <div class="oh-action-group">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="oh-btn-edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="oh-btn-delete"
                                    onclick="return confirm('ចង់លប់មែនទេ?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="oh-table-footer">
        Showing {{ $categories->count() }} categories
    </div>
</div>

<style>
.oh-page-title { font-size: 24px; font-weight: 700; color: #1a2e1f; letter-spacing: -.4px; margin: 0 0 2px; }
.oh-page-sub   { font-size: 12.5px; color: #7a8c80; margin: 0; }

.oh-btn-primary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px; border-radius: 99px;
    background: #1e3a2b; color: #fff;
    font-size: 13px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    transition: background .15s;
}
.oh-btn-primary:hover { background: #2d5a3d; color: #fff; }

.oh-table-wrap {
    background: #fff;
    border: 1px solid #e2e6de;
    border-radius: 14px;
    overflow: hidden;
    margin-top: 16px;
}

.oh-table { width: 100%; border-collapse: collapse; }

.oh-table thead tr {
    border-bottom: 1px solid #e2e6de;
}
.oh-table thead th {
    padding: 11px 16px;
    font-size: 10.5px; font-weight: 600;
    letter-spacing: .8px; text-transform: uppercase;
    color: #7a8c80; background: #fff;
    text-align: left;
}

.oh-table tbody tr {
    border-bottom: 1px solid #f0f2ee;
    transition: background .12s;
}
.oh-table tbody tr:last-child { border-bottom: none; }
.oh-table tbody tr:hover { background: #fafbf8; }

.oh-table tbody td { padding: 13px 16px; font-size: 13.5px; color: #1a2e1f; vertical-align: middle; }
.oh-td-muted { color: #7a8c80 !important; font-size: 13px !important; }

td { font-weight: 500; }

.oh-slug {
    display: inline-block;
    background: #f0f2ee; color: #5a7a65;
    font-size: 11.5px; font-weight: 500;
    padding: 3px 9px; border-radius: 6px;
    font-family: monospace;
}

.oh-action-group { display: flex; align-items: center; gap: 6px; }

.oh-btn-edit {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 12px; border-radius: 7px;
    background: #eef6f0; color: #1e5234;
    border: 1px solid #c0ddc8;
    font-size: 12px; font-weight: 500;
    text-decoration: none; cursor: pointer;
    transition: background .15s;
}
.oh-btn-edit:hover { background: #d6ead9; color: #1e3a2b; }

.oh-btn-delete {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 12px; border-radius: 7px;
    background: #fdf0f0; color: #8a2020;
    border: 1px solid #f5c0c0;
    font-size: 12px; font-weight: 500;
    cursor: pointer;
    transition: background .15s;
}
.oh-btn-delete:hover { background: #fadadd; color: #6a1010; }

.oh-table-footer {
    padding: 10px 16px;
    font-size: 11.5px; color: #7a8c80;
    border-top: 1px solid #f0f2ee;
    background: #fff;
}
</style>
@endsection
