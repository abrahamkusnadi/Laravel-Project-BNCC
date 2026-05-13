@extends('layout.master')

@section('title','Invoices')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">My Invoices</h1>

    @forelse($invoices as $invoice)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    Invoice #{{ $invoice->invoice_number ?? $invoice->id }} 
                    | Total: Rp {{ number_format($invoice->total_price,0,',','.') }}
                </span>

                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Yakin hapus faktur ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete Invoice</button>
                </form>
            </div>
            <div class="card-body">
                <p><strong>Address:</strong> {{ $invoice->address }}</p>
                <p><strong>Postal Code:</strong> {{ $invoice->postal_code }}</p>
                <p><strong>Date:</strong> {{ $invoice->created_at->format('d M Y H:i') }}</p>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
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
    @empty
        <p class="text-center">No invoices available.</p>
    @endforelse
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $invoices->links('pagination::bootstrap-5') }}
</div>
@endsection
