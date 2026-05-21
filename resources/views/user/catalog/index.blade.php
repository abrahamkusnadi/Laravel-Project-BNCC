@extends('layout.user')

@section('title', 'Shop Catalog')

@section('content')
@php // To remove error from PHP intellisense, these variables are passed from CatalogController@index method.
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
     * @var \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
     */
@endphp
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 mt-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Shop Catalog</h1>
            <p class="text-gray-500 mt-1">Find everything you need here.</p>
        </div>
        
        <div class="w-full md:w-80">
            <form action="{{ route('user.catalog') }}" method="GET" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-900 focus:border-gray-900 sm:text-sm transition shadow-sm">
            </form>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('user.catalog') }}" class="px-5 py-2 rounded-full text-sm font-medium transition {{ !request('category_id') ? 'bg-gray-900 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All
        </a>
        @foreach($categories ?? [] as $category)
            <a href="{{ route('user.catalog', ['category_id' => $category->id]) }}" class="px-5 py-2 rounded-full text-sm font-medium transition {{ request('category_id') == $category->id ? 'bg-gray-900 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 text-sm border border-green-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 text-sm border border-red-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products ?? [] as $product)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow duration-300">
                <div class="h-52 bg-gray-50 overflow-hidden relative group">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <span class="inline-block px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider rounded-md mb-3 w-fit">
                        {{ $product->category->name }}
                    </span>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-1">{{ $product->name }}</h3>
                    <p class="text-gray-700 font-semibold mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mb-5">Stock: {{ $product->stock }}</p>

                    <div class="mt-auto">
                        <form action="{{ route('user.catalog.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" @if($product->stock < 1) disabled @endif class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-medium transition {{ $product->stock > 0 ? 'bg-gray-900 hover:bg-black text-white shadow-sm' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-16">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">No products found</h3>
                <p class="text-gray-500 text-sm">Try adjusting your search or category filters.</p>
            </div>
        @endforelse
    </div>
@endsection