@extends('layout.master')

@section('title','Faktur')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Faktur Saya</h1>

    @foreach($invoices as $invoice)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    Faktur #{{ $invoice->invoice_number ?? $invoice->id }} 
                    | Total: Rp {{ number_format($invoice->total_price,0,',','.') }}
                </span>

                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Yakin hapus faktur ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus Faktur</button>
                </form>
            </div>
            <div class="card-body">
                <p><strong>Alamat:</strong> {{ $invoice->address }}</p>
                <p><strong>Kode Pos:</strong> {{ $invoice->postal_code }}</p>
                <p><strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y H:i') }}</p>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->subtotal / $item->quantity, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $invoices->links('pagination::bootstrap-5') }}
</div>
@endsection
