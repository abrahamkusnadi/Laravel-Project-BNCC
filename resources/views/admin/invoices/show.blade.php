@extends('layout.admin')

@section('title', 'Invoice Details')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition flex items-center gap-2">
                &larr; Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl font-bold text-gray-900">Invoice #{{ $invoice->invoice_number }}</h1>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full capitalize bg-green-100 text-green-700">
                        {{ $invoice->status }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 font-medium">Customer: <span class="text-gray-900">{{ $invoice->user->name ?? 'Guest' }}</span></p>
                    <p class="text-sm text-gray-500">{{ $invoice->created_at->format('M d, Y - H:i') }}</p>
                </div>
            </div>
            
            {{-- Form dihilangkan karena ini mode Read-Only untuk Admin --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-sm font-semibold text-gray-500 mb-2">Delivery Address</label>
                    <div class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 text-sm">
                        {{ $invoice->address }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-500 mb-2">Postal Code</label>
                    <div class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 text-sm">
                        {{ $invoice->postal_code }}
                    </div>
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
                            <td class="py-5 font-medium">{{ $item->product->name }}</td>
                            {{-- Input number dihilangkan, diganti dengan text statis --}}
                            <td class="py-5 text-center">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-md font-semibold">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td class="py-5 text-right font-medium text-gray-600">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 pt-6 flex justify-end">
                <div class="text-right">
                    <p class="text-sm text-gray-500 font-medium mb-1">Total Price</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

        </div>
    </div>
@endsection