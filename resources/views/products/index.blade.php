@extends('layout.master')

@section('title', 'Products')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Produk - Produk</h1>

    @auth
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Product</a>
        @endif
    @endauth
    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'user')
                        <th>Action</th>
                    @endif
                @endauth
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/images/' . $product->image) }}" style="width: 100px; height: 100px">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    @auth
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'user')
                            <td>
                                {{-- Admin: Edit & Delete --}}
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus produk ini?')">Delete</button>
                                    </form>
                                @endif

                                {{-- User: Tambah ke Faktur --}}
                                @if(Auth::user()->role === 'user')
                                    <form action="{{ route('invoices.add', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Tambah ke Faktur</button>
                                    </form>
                                @endif
                            </td>
                        @endif
                    @endauth
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
