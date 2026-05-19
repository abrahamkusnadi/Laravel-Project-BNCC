@extends('layout.master')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Product</h1>
        <p class="text-sm text-gray-500 mt-1">Update the details and stock of your inventory item.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-200 appearance-none text-gray-900" required>
                        <option value="" disabled>Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" minlength="5" maxlength="80" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-200">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Price (IDR)</label>
                        <div class="relative mt-1 rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-200">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Product Image</label>
                    
                    <div class="flex items-center gap-6 mt-2">
                        @if($product->image)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="h-24 w-24 object-cover rounded-xl border border-gray-200 shadow-sm">
                            </div>
                        @else
                            <div class="flex-shrink-0 h-24 w-24 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-xs text-center p-2">
                                No image
                            </div>
                        @endif

                        <div class="flex-grow">
                            <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                            <p class="mt-2 text-xs text-gray-500">Leave blank if you don't want to change the image. (PNG, JPG max 2MB)</p>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection