@extends('layout.master')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Products</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your inventory and add items to invoices</p>
        </div>
        
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                    + Add New Product
                </a>
            @endif
        @endauth
    </div>

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-500">
                        <th class="py-4 px-6 font-medium">ID</th>
                        <th class="py-4 px-6 font-medium">Category</th>
                        <th class="py-4 px-6 font-medium">Name</th>
                        <th class="py-4 px-6 font-medium">Price</th>
                        <th class="py-4 px-6 font-medium text-center">Stock</th>
                        <th class="py-4 px-6 font-medium">Image</th>
                        @auth
                            <th class="py-4 px-6 font-medium text-right">Actions</th>
                        @endauth
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6 text-gray-400">{{ $product->id }}</td>
                            
                            <td class="py-4 px-6">
                                <span class="bg-gray-100 border border-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-6 font-medium text-gray-900">{{ $product->name }}</td>
                            
                            <td class="py-4 px-6 text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            
                            <td class="py-4 px-6 text-center">
                                @if($product->stock < 10)
                                    <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-medium">{{ $product->stock }}</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium">{{ $product->stock }}</span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 shadow-sm" alt="{{ $product->name }}">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                        No img
                                    </div>
                                @endif
                            </td>
                            
                            @auth
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-4">
                                        
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-gray-400 hover:text-blue-600 transition" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'user')
                                            <form action="{{ route('invoices.add', $product->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    Add to Invoice
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p>No products available.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection