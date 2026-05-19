@extends('layout.master')

@section('title', 'My Invoices')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">My Invoices</h1>
        <p class="text-sm text-gray-500 mt-1">Review and manage your purchase history</p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @forelse($invoices as $invoice)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
            
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Invoice #{{ $invoice->invoice_number ?? $invoice->id }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Created on {{ $invoice->created_at->format('M d, Y - H:i') }}</p>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $invoice->status == 'pending' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} 
                        capitalize">
                        {{ $invoice->status }}
                    </span>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('invoices.show', $invoice->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded-lg transition-colors">
                        View / Edit
                    </a>
                    
                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 bg-red-50 px-4 py-2 rounded-lg transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 text-sm text-gray-600">
                    <div>
                        <span class="block font-semibold text-gray-900 mb-1">Shipping Address</span>
                        {{ $invoice->address }}
                    </div>
                    <div>
                        <span class="block font-semibold text-gray-900 mb-1">Postal Code</span>
                        {{ $invoice->postal_code }}
                    </div>
                </div>

                <div class="border rounded-lg overflow-hidden border-gray-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-500">
                            <tr>
                                <th class="py-3 px-4 font-medium">Product</th>
                                <th class="py-3 px-4 font-medium text-center">Qty</th>
                                <th class="py-3 px-4 font-medium text-right">Price</th>
                                <th class="py-3 px-4 font-medium text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-gray-700">
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td class="py-3 px-4">{{ $item->product->name }}</td>
                                    <td class="py-3 px-4 text-center">{{ $item->quantity }}</td>
                                    <td class="py-3 px-4 text-right">Rp {{ number_format($item->subtotal / $item->quantity, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t border-gray-100">
                            <tr>
                                <td colspan="3" class="py-3 px-4 text-right font-semibold text-gray-900">Total Amount:</td>
                                <td class="py-3 px-4 text-right font-bold text-gray-900 text-base">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 py-16 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <p>No invoices available.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 text-sm font-medium text-blue-600 hover:underline">Browse Products</a>
        </div>
    @endforelse

    <div class="mt-8">
        {{ $invoices->links() }}
    </div>
    
</div>
@endsection