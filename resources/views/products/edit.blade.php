@extends('layout.master')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">Edit Product</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa error:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" 
                   name="name" 
                   class="form-control" 
                   minlength="5" maxlength="80" 
                   value="{{ old('name', $product->name) }}" 
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" 
                   name="price" 
                   class="form-control" 
                   value="{{ old('price', $product->price) }}" 
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" 
                   name="stock" 
                   class="form-control" 
                   value="{{ old('stock', $product->stock) }}" 
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         width="120" 
                         class="img-thumbnail">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
