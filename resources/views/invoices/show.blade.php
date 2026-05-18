@extends('layout.master')

@section('title', 'Invoice Details')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
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

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        
        {{-- Header & Date --}}
        <div class="mb-8 border-b border-gray-100 pb-6">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Invoice #{{ $invoice->invoice_number }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $invoice->created_at->format('M d, Y') }}</p>
        </div>

        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Input Address & Postal Code --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Address</label>
                    <input type="text" name="address" value="{{ old('address', $invoice->address) }}" 
                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Postal Code</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $invoice->postal_code) }}" 
                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900 transition" required>
                </div>
            </div>

            {{-- Items Table --}}
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
                                       class="w-20 bg-gray-50 border border-gray-200 text-center rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 transition mx-auto">
                            </td>
                            <td class="py-5 text-right font-medium text-gray-600">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer (Total & Buttons) --}}
            <div class="border-t border-gray-200 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                {{-- Back Button --}}
                <a href="{{ route('invoices.index') }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>

                {{-- Total & Save --}}
                <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-medium">Total Price</p>
                        <p class="text-lg font-bold text-gray-900">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</p>
                    </div>
                    <button type="submit" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                        Save Changes
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection