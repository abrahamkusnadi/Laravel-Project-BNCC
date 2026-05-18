@extends('layout.master')

@section('title', 'Categories')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Categories</h1>
            <p class="text-sm text-gray-500 mt-1">Organize and manage your product categories</p>
        </div>
        
        {{-- Tombol Add Category (Hanya Admin) --}}
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                    + Add New Category
                </a>
            @endif
        @endauth
    </div>

    {{-- Alert Messages --}}
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

    {{-- Table Container --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-500">
                        <th class="py-4 px-6 font-medium">Category Name</th>
                        <th class="py-4 px-6 font-medium">Description</th>
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <th class="py-4 px-6 font-medium text-right">Actions</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            {{-- Nama Kategori --}}
                            <td class="py-4 px-6 font-medium text-gray-900 w-1/4">{{ $category->name }}</td>
                            
                            {{-- Deskripsi Kategori --}}
                            <td class="py-4 px-6 text-gray-500">
                                {{ $category->description ?? 'No description provided' }}
                            </td>
                            
                            {{-- Actions (Hanya Admin) --}}
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <td class="py-4 px-6 w-32">
                                        <div class="flex items-center justify-end gap-4">
                                            {{-- Icon Edit --}}
                                            <a href="{{ route('categories.edit', $category->id) }}" class="text-gray-400 hover:text-blue-600 transition" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            
                                            {{-- Icon Delete --}}
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-500">
                                {{-- Ikon Folder Kosong --}}
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                <p>No categories available.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection