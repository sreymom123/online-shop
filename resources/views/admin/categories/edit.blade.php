@extends('admin.layouts.app')

@section('content')
<h2>Edit Category</h2>

<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control"
               value="{{ $category->name }}" required>
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"
                  rows="3">{{ $category->description }}</textarea>
    </div>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection