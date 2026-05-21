@extends('layout.user')

@section('title', 'My Invoices')

@section('content')
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">My Invoices</h1>
            <p class="text-sm text-gray-500 mt-1">Review and manage your purchase history</p>
        </div>

        {{-- Alert Messages --}}
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Invoice List --}}
        @forelse($invoices as $invoice)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden hover:shadow-md transition-shadow duration-300">
                
                {{-- Card Header --}}
                <div class="bg-gray-50/50 px-6 py-5 border-b border-gray-100 flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Invoice #{{ $invoice->invoice_number ?? $invoice->id }}</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Created on {{ $invoice->created_at->format('M d, Y - H:i') }}</p>
                        
                        {{-- Consistent Status Badge --}}
                        <div class="mt-3">
                            @if($invoice->status == 'completed')
                                <span class="bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Completed</span>
                            @else
                                <span class="bg-red-50 text-red-500 border border-red-100 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Pending</span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-3">
                        {{-- Dark Theme Button for Consistency --}}
                        <a href="{{ route('user.invoices.show', $invoice->id) }}" class="text-sm font-medium text-white bg-gray-900 hover:bg-black px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                            View Details
                        </a>
                        
                        <form action="{{ route('user.invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-4 py-2.5 rounded-xl transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6">
                    {{-- Shipping Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-sm text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <span class="flex items-center gap-2 font-semibold text-gray-900 mb-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Shipping Address
                            </span>
                            <p class="pl-6">{{ $invoice->address }}</p>
                        </div>
                        <div>
                            <span class="flex items-center gap-2 font-semibold text-gray-900 mb-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Postal Code
                            </span>
                            <p class="pl-6">{{ $invoice->postal_code }}</p>
                        </div>
                    </div>

                    {{-- Clean Table Style --}}
                    <div class="border rounded-xl overflow-hidden border-gray-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500">
                                <tr>
                                    <th class="py-4 px-5 font-semibold text-xs uppercase tracking-wider">Product</th>
                                    <th class="py-4 px-5 font-semibold text-xs uppercase tracking-wider text-center">Qty</th>
                                    <th class="py-4 px-5 font-semibold text-xs uppercase tracking-wider text-right">Price</th>
                                    <th class="py-4 px-5 font-semibold text-xs uppercase tracking-wider text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-gray-700">
                                @foreach($invoice->items as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-3 px-5 font-medium text-gray-900">{{ $item->product->name }}</td>
                                        <td class="py-3 px-5 text-center bg-gray-50/50">{{ $item->quantity }}</td>
                                        <td class="py-3 px-5 text-right">Rp {{ number_format($item->subtotal / $item->quantity, 0, ',', '.') }}</td>
                                        <td class="py-3 px-5 text-right font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 border-t border-gray-100">
                                <tr>
                                    <td colspan="3" class="py-4 px-5 text-right font-medium text-gray-500">Total Amount:</td>
                                    <td class="py-4 px-5 text-right font-bold text-gray-900 text-lg">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
            </div>
        @empty
            {{-- Empty State Design --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 py-24 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-6">
                    <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No invoices available.</h3>
                <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">It looks like you haven't made any purchases or added anything to your cart yet.</p>
                <a href="{{ route('user.catalog') }}" class="inline-block bg-gray-900 text-white px-6 py-3 rounded-xl text-sm font-medium hover:bg-black transition-colors shadow-sm">
                    Start Shopping
                </a>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $invoices->links() }}
        </div>
        
    </div>
@endsection