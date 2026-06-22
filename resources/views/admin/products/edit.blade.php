@extends('admin.layouts.app')

@section('content')
<h2>Edit Product</h2>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control"
               value="{{ $product->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"
                  rows="3">{{ $product->description }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" name="price" class="form-control"
                   step="0.01" value="{{ $product->price }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control"
                   value="{{ $product->stock }}">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Image</label>
        @if($product->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $product->image) }}"
                     width="100" height="100" style="object-fit:cover">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection