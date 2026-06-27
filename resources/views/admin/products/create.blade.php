@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="oh-page-title">Create Product</h1>
    <p class="oh-page-sub">Add a new product to your harvest catalog.</p>
</div>

<div class="oh-form-card">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="oh-field">
            <label class="oh-label">Name</label>
            <input type="text" name="name" class="oh-input" placeholder="e.g. Heirloom Carrots" required>
            @error('name')<span class="oh-error">{{ $message }}</span>@enderror
        </div>

        <div class="oh-field">
            <label class="oh-label">Category</label>
            <select name="category_id" class="oh-input" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<span class="oh-error">{{ $message }}</span>@enderror
        </div>

        <div class="oh-field">
            <label class="oh-label">Description</label>
            <textarea name="description" class="oh-input oh-textarea" rows="3"
                      placeholder="Brief description of this product..."></textarea>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="oh-field">
                    <label class="oh-label">Price ($)</label>
                    <input type="number" name="price" class="oh-input"
                           step="0.01" min="0" placeholder="0.00" required>
                    @error('price')<span class="oh-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="oh-field">
                    <label class="oh-label">Stock</label>
                    <input type="number" name="stock" class="oh-input" min="0" value="0">
                </div>
            </div>
        </div>

        <div class="oh-field">
            <label class="oh-label">Image</label>
            <input type="file" name="image" class="oh-input" accept="image/*">
        </div>

        <div class="oh-form-actions">
            <a href="{{ route('admin.products.index') }}" class="oh-btn-secondary">← Back</a>
            <button type="submit" class="oh-btn-primary">Save Product</button>
        </div>
    </form>
</div>

<style>
.oh-page-title { font-size: 24px; font-weight: 700; color: #1a2e1f; letter-spacing: -.4px; margin: 0 0 2px; }
.oh-page-sub   { font-size: 12.5px; color: #7a8c80; margin: 0; }
.oh-form-card  { background: #fff; border: 1px solid #e2e6de; border-radius: 14px; padding: 28px; max-width: 620px; }
.oh-field      { margin-bottom: 18px; }
.oh-label      { display: block; font-size: 12px; font-weight: 600; color: #1e3a2b; margin-bottom: 7px; }
.oh-input {
    width: 100%; padding: 10px 14px;
    border: 1px solid #e2e6de; border-radius: 10px;
    font-size: 13.5px; font-family: 'Inter', sans-serif;
    background: #f7f8f5; color: #1a2e1f; outline: none;
    transition: border-color .15s, background .15s;
}
.oh-input::placeholder { color: #b0bcb4; }
.oh-input:focus { border-color: #5a8a6a; background: #fff; box-shadow: 0 0 0 3px rgba(90,138,106,.12); }
.oh-textarea   { resize: vertical; }
.oh-error      { font-size: 12px; color: #8a2020; margin-top: 4px; display: block; }
.oh-form-actions { display: flex; align-items: center; gap: 10px; margin-top: 8px; }
.oh-btn-primary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 99px;
    background: #1e3a2b; color: #fff;
    font-size: 13px; font-weight: 600;
    border: none; cursor: pointer; text-decoration: none;
    transition: background .15s;
}
.oh-btn-primary:hover { background: #2d5a3d; color: #fff; }
.oh-btn-secondary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 99px;
    background: transparent; color: #5a7a65;
    font-size: 13px; font-weight: 600;
    border: 1px solid #e2e6de; cursor: pointer; text-decoration: none;
    transition: background .15s;
}
.oh-btn-secondary:hover { background: #f0f2ee; color: #1e3a2b; }
</style>
@endsection
