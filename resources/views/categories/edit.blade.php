@extends('layout.master')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Category</h1>
        <p class="text-sm text-gray-500 mt-1">Update the details of your category.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Category Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Description</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                    Back to List
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection