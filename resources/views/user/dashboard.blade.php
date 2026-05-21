@extends('layout.user')

@section('title', 'My Dashboard')

@section('content')

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-gradient-to-r from-[#6b73ff] to-[#a380f6] rounded-3xl p-10 text-white shadow-md mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -translate-y-10 translate-x-10"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-3 tracking-tight">Welcome back to your shopping hub!</h1>
            <p class="text-indigo-100 mb-8 max-w-xl text-sm leading-relaxed">
                Discover amazing products, track your orders, and enjoy a seamless shopping experience with Meksiko Inc.
            </p>
            <a href="{{ route('user.catalog') }}" class="inline-block bg-gray-900 text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-black transition shadow-sm">
                Browse Catalog
            </a>
        </div>
    </div>

    {{-- Metrics Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Active Cart --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4 text-orange-500">
                <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Active Cart</p>
            </div>
            <p class="text-4xl font-bold text-gray-900">{{ $data['pending_cart'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-2">items ready to checkout</p>
        </div>

        {{-- Completed Orders --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4 text-blue-500">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Completed Orders</p>
            </div>
            <p class="text-4xl font-bold text-gray-900">{{ $data['total_invoices'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-2">orders delivered</p>
        </div>

        {{-- Total Spent --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4 text-green-500">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Spent</p>
            </div>
            <p class="text-4xl font-bold text-gray-900">Rp {{ number_format($data['total_spent'] ?? 0, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-2">lifetime purchases</p>
        </div>
    </div>

    {{-- Recent Activity List --}}
    <section>
        <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h2>
        
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            @forelse($data['recent_invoices'] ?? [] as $invoice)
                <div class="flex items-center justify-between p-5 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Invoice #{{ $invoice->invoice_number ?? $invoice->id }}</p>
                            <p class="text-xs text-gray-500">{{ $invoice->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="text-right flex items-center gap-6">
                        <p class="text-sm font-bold text-gray-900">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</p>
                        
                        <div class="w-24 text-right">
                            @if($invoice->status == 'completed')
                                <span class="bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Completed</span>
                            @else
                                <span class="bg-red-50 text-red-500 border border-red-100 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Pending</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center">
                    <p class="text-gray-500 text-sm">You haven't made any purchases yet.</p>
                    <a href="{{ route('user.catalog') }}" class="text-indigo-600 font-medium text-sm hover:underline mt-2 inline-block">Start Shopping &rarr;</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection