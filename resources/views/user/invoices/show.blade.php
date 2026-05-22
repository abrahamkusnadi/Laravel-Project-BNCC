@extends('layout.user')

@section('title', 'Invoice Details')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
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

        {{-- Top Navigation & Print Action --}}
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('user.invoices.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition flex items-center gap-2">
                &larr; Back to Invoices
            </a>

            {{-- Tombol Print Hanya Muncul Jika Invoice Sudah Completed --}}
            @if($invoice->status == 'completed')
                <a href="{{ route('user.invoices.print', $invoice->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-gray-900 hover:bg-black text-white text-sm font-medium px-5 py-2.5 rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Invoice
                </a>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl font-bold text-gray-900">Invoice #{{ $invoice->invoice_number }}</h1>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full capitalize {{ $invoice->status == 'pending' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $invoice->status }}
                    </span>
                </div>
                <p class="text-sm text-gray-500">{{ $invoice->created_at->format('M d, Y') }}</p>
            </div>
            
            <form action="{{ route('user.invoices.update', $invoice->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Address</label>
                        <input type="text" name="address" value="{{ old('address', $invoice->address) }}" 
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900 transition disabled:opacity-60 disabled:cursor-not-allowed" 
                            {{ $invoice->status == 'completed' ? 'disabled' : 'required' }}>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $invoice->postal_code) }}" 
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900 transition disabled:opacity-60 disabled:cursor-not-allowed" 
                            {{ $invoice->status == 'completed' ? 'disabled' : 'required' }}>
                    </div>
                </div>

                <div class="mb-8">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-sm text-gray-500">
                                <th class="py-3 font-semibold w-1/2">Product Name</th>
                                <th class="py-3 font-semibold text-center">Quantity</th>
                                <th class="py-3 font-semibold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
                            @foreach($invoice->items as $item)
                            <tr>
                                <td class="py-5">{{ $item->product->name }}</td>
                                <td class="py-5 text-center">
                                    <input type="number" name="items[{{ $item->id }}][quantity]" 
                                        value="{{ old('items.'.$item->id.'.quantity', $item->quantity) }}" 
                                        min="1" 
                                        class="w-20 bg-gray-50 border border-gray-200 text-center rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 transition mx-auto disabled:opacity-60 disabled:cursor-not-allowed"
                                        {{ $invoice->status == 'completed' ? 'disabled' : '' }}>
                                </td>
                                <td class="py-5 text-right font-medium text-gray-600">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 pt-6 flex flex-col sm:flex-row justify-end items-center gap-4">
                    <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
                        <div class="text-right">
                            <p class="text-xs text-gray-500 font-medium">Total Price</p>
                            <p class="text-lg font-bold text-gray-900">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</p>
                        </div>
                        
                        {{-- Tombol Save Changes Hanya Muncul Jika Masih Pending --}}
                        @if($invoice->status == 'pending')
                            <button type="submit" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                                Complete Checkout
                            </button>
                        @endif
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection