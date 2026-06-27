@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="oh-page-title">Edit Category</h1>
    <p class="oh-page-sub">Update the details for this category.</p>
</div>

<div class="oh-form-card">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="oh-field">
            <label class="oh-label">Name</label>
            <input type="text" name="name" class="oh-input"
                   value="{{ $category->name }}" required>
            @error('name')
                <span class="oh-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="oh-field">
            <label class="oh-label">Description</label>
            <textarea name="description" class="oh-input oh-textarea"
                      rows="3">{{ $category->description }}</textarea>
        </div>

        <div class="oh-form-actions">
            <a href="{{ route('admin.categories.index') }}" class="oh-btn-secondary">← Back</a>
            <button type="submit" class="oh-btn-primary">Update Category</button>
        </div>
    </form>
</div>

<style>
.oh-page-title { font-size: 24px; font-weight: 700; color: #1a2e1f; letter-spacing: -.4px; margin: 0 0 2px; }
.oh-page-sub   { font-size: 12.5px; color: #7a8c80; margin: 0; }

.oh-form-card {
    background: #fff;
    border: 1px solid #e2e6de;
    border-radius: 14px;
    padding: 28px;
    max-width: 560px;
}

.oh-field { margin-bottom: 20px; }

.oh-label {
    display: block;
    font-size: 12px; font-weight: 600;
    color: #1e3a2b; margin-bottom: 7px;
}

.oh-input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e6de;
    border-radius: 10px;
    font-size: 13.5px;
    font-family: 'Inter', sans-serif;
    background: #f7f8f5;
    color: #1a2e1f;
    outline: none;
    transition: border-color .15s, background .15s;
}
.oh-input::placeholder { color: #b0bcb4; }
.oh-input:focus { border-color: #5a8a6a; background: #fff; box-shadow: 0 0 0 3px rgba(90,138,106,.12); }
.oh-textarea { resize: vertical; }

.oh-error { font-size: 12px; color: #8a2020; margin-top: 4px; display: block; }

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
