<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }} - Meksiko Inc.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* CSS Khusus Print (Menghilangkan tombol print saat dicetak di kertas) */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
            @page { margin: 15mm; size: A4; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 py-10 antialiased">

    {{-- Tombol Aksi (Hanya terlihat di layar, hilang saat dicetak) --}}
    <div class="max-w-4xl mx-auto mb-6 px-8 flex justify-between items-center no-print">
        <a href="{{ route('user.invoices.show', $invoice->id) }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition flex items-center gap-2">
            &larr; Back to Details
        </a>
        <button onclick="window.print()" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-lg text-sm font-medium shadow-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print / Save as PDF
        </button>
    </div>

    {{-- Kertas Invoice --}}
    <div class="max-w-4xl mx-auto bg-white p-12 shadow-sm border border-gray-200">
        
        {{-- Header --}}
        <div class="flex justify-between items-start mb-12">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Meksiko Inc.</h1>
                <p class="text-sm text-gray-500 mt-1">Premium Commerce Platform</p>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-bold text-gray-200 uppercase tracking-widest">Invoice</h2>
            </div>
        </div>

        {{-- Meta Data (Kiri: Alamat, Kanan: Info Invoice) --}}
        <div class="grid grid-cols-2 gap-8 mb-10">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Billed To</p>
                <h3 class="text-base font-bold text-gray-900">{{ $invoice->user->name ?? 'Guest' }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed mt-1">
                    {{ $invoice->address }}<br>
                    Postal Code: {{ $invoice->postal_code }}
                </p>
            </div>
            
            <div class="text-right flex flex-col justify-end">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Invoice Details</p>
                <div class="text-sm flex justify-end gap-6 mb-1">
                    <span class="text-gray-500">Invoice No:</span>
                    <span class="font-bold text-gray-900">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="text-sm flex justify-end gap-6 mb-1">
                    <span class="text-gray-500">Date:</span>
                    <span class="font-medium text-gray-900">{{ $invoice->created_at->format('M d, Y') }}</span>
                </div>
                <div class="text-sm flex justify-end gap-6">
                    <span class="text-gray-500">Status:</span>
                    <span class="font-bold text-green-600 uppercase">{{ $invoice->status }}</span>
                </div>
            </div>
        </div>

        {{-- Tabel Barang --}}
        <table class="w-full text-left mb-10">
            <thead>
                <tr class="border-b-2 border-gray-900 text-xs font-bold text-gray-900 uppercase tracking-wider">
                    <th class="py-3 px-2">Product</th>
                    <th class="py-3 px-2 text-center">Qty</th>
                    <th class="py-3 px-2 text-right">Price</th>
                    <th class="py-3 px-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                @foreach($invoice->items as $item)
                <tr>
                    <td class="py-4 px-2 font-medium text-gray-900">{{ $item->product->name }}</td>
                    <td class="py-4 px-2 text-center text-gray-500">{{ $item->quantity }}</td>
                    <td class="py-4 px-2 text-right">Rp {{ number_format($item->subtotal / $item->quantity, 0, ',', '.') }}</td>
                    <td class="py-4 px-2 text-right font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Total Kalkulasi --}}
        <div class="w-1/2 ml-auto">
            <div class="flex justify-between items-center py-2 text-sm text-gray-600">
                <span>Subtotal</span>
                <span>Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center py-2 text-sm text-gray-600">
                <span>Tax (0%)</span>
                <span>Rp 0</span>
            </div>
            <div class="flex justify-between items-center py-4 mt-2 border-t border-gray-200">
                <span class="font-bold text-gray-900">Total Amount</span>
                <span class="font-bold text-xl text-gray-900">Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-20 pt-8 border-t border-gray-100 text-center text-xs text-gray-400">
            <p>Thank you for shopping with Meksiko Inc.</p>
            <p class="mt-1">If you have any questions concerning this invoice, contact support@meksiko.inc</p>
        </div>

    </div>

</body>
</html>