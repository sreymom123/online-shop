@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="oh-page-title">Products</h1>
        <p class="oh-page-sub">Manage your organic harvest listings and stock levels.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="oh-btn-primary">
        + Add Product
    </a>
</div>

<div class="oh-table-wrap">
    <table class="oh-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td class="oh-td-muted">{{ $product->id }}</td>
                <td>
                    <div class="oh-product-cell">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 class="oh-product-img" width="40" height="40"
                                 style="object-fit:cover">
                        @else
                            <div class="oh-product-img oh-product-placeholder">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                        <div>
                            <div class="oh-product-name">{{ $product->name }}</div>
                            <div class="oh-product-tag">Organic</div>
                        </div>
                    </div>
                </td>
                <td><span class="oh-slug">{{ $product->category->name }}</span></td>
                <td class="oh-price">${{ $product->price }}</td>
                <td class="oh-td-muted"><span class="oh-stock-dot">●</span> {{ $product->stock }}</td>
                <td>
                    <div class="oh-action-group">
                        <a href="{{ route('admin.products.edit', $product) }}" class="oh-btn-edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}"
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

    {{-- Pagination Footer --}}
    <div class="oh-table-footer">
        <span>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products</span>

        @if($products->lastPage() > 1)
        <div class="oh-pagination">
            {{-- Prev --}}
            <a href="{{ $products->previousPageUrl() ?? '#' }}"
               class="oh-page-btn oh-page-arrow {{ $products->onFirstPage() ? 'disabled' : '' }}">
                ‹
            </a>

            {{-- Page numbers --}}
            @for($i = 1; $i <= $products->lastPage(); $i++)
                <a href="{{ $products->url($i) }}"
                   class="oh-page-btn {{ $products->currentPage() === $i ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            {{-- Next --}}
            <a href="{{ $products->nextPageUrl() ?? '#' }}"
               class="oh-page-btn oh-page-arrow {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                ›
            </a>
        </div>
        @endif
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

.oh-product-cell { display: flex; align-items: center; gap: 10px; }
.oh-product-img { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
.oh-product-placeholder {
    width: 40px; height: 40px; border-radius: 8px;
    background: #f0f2ee; display: flex; align-items: center;
    justify-content: center; color: #b0bcb4; font-size: 16px; flex-shrink: 0;
}
.oh-product-name { font-weight: 600; color: #1a2e1f; font-size: 13.5px; }
.oh-product-tag  { font-size: 10.5px; color: #5a8a6a; margin-top: 1px; }

.oh-slug {
    display: inline-block;
    background: #f0f2ee; color: #5a7a65;
    font-size: 11.5px; font-weight: 500;
    padding: 3px 9px; border-radius: 6px;
}
.oh-price { font-weight: 600; color: #1a2e1f; }
.oh-stock-dot { color: #2d7a45; font-size: 10px; margin-right: 3px; }

.oh-action-group { display: flex; align-items: center; gap: 6px; }
.oh-btn-edit {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 12px; border-radius: 7px;
    background: #eef6f0; color: #1e5234;
    border: 1px solid #c0ddc8;
    font-size: 12px; font-weight: 500;
    text-decoration: none; transition: background .15s;
}
.oh-btn-edit:hover { background: #d6ead9; color: #1e3a2b; }
.oh-btn-delete {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 12px; border-radius: 7px;
    background: #fdf0f0; color: #8a2020;
    border: 1px solid #f5c0c0;
    font-size: 12px; font-weight: 500; cursor: pointer;
    transition: background .15s;
}
.oh-btn-delete:hover { background: #fadadd; color: #6a1010; }

/* ── FOOTER + PAGINATION ── */
.oh-table-footer {
    padding: 10px 16px;
    font-size: 11.5px; color: #7a8c80;
    border-top: 1px solid #f0f2ee;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}

.oh-pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.oh-page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    height: 30px;
    padding: 0 8px;
    border-radius: 7px;
    font-size: 12.5px;
    font-weight: 500;
    color: #4a5e4f;
    background: transparent;
    border: 1px solid transparent;
    text-decoration: none;
    transition: background .12s, border-color .12s, color .12s;
    cursor: pointer;
}

.oh-page-btn:hover:not(.disabled):not(.active) {
    background: #f0f2ee;
    border-color: #d8ddd5;
    color: #1a2e1f;
}

.oh-page-btn.active {
    background: #1e3a2b;
    color: #fff;
    border-color: #1e3a2b;
    cursor: default;
}

.oh-page-btn.disabled {
    color: #c0ccc4;
    cursor: not-allowed;
    pointer-events: none;
}

.oh-page-arrow {
    font-size: 16px;
    color: #7a8c80;
}
</style>
@endsection
