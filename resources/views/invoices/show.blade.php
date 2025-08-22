@extends('layout.master')

@section('title', 'Detail Faktur')

@section('content')
<h1>Faktur #{{ $invoice->invoice_number }}</h1>

<form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label><strong>Alamat:</strong></label>
        <input type="text" name="address" value="{{ old('address', $invoice->address) }}" 
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label><strong>Kode Pos:</strong></label>
        <input type="text" name="postal_code" value="{{ old('postal_code', $invoice->postal_code) }}" 
               class="form-control" required>
    </div>

    <p><strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y H:i') }}</p>

    <table class="table">
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
        @foreach($invoice->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>
                <input type="number" name="items[{{ $item->id }}][quantity]" 
                       value="{{ old('items.'.$item->id.'.quantity', $item->quantity) }}" 
                       min="1" class="form-control" style="width:100px;">
            </td>
            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2"><strong>Total</strong></td>
            <td><strong>Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
