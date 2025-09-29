@extends('layout.master')

@section('title', 'Categories')

@section('content')
    <h1>Kategori - Kategori </h1>

    @auth
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Tambah Category</a>
        @endif
    @endauth

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            {{-- Kolom Action hanya admin --}}
            @auth
                @if(Auth::user()->role === 'admin')
                    <th>Action</th>
                @endif
            @endauth
        </tr>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </td>
                    @endif
                @endauth
            </tr>
        @endforeach
    </table>
@endsection
