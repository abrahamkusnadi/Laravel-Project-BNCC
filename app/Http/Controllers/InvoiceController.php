<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_item;
use App\Models\InvoiceItem;   // <- ubah jadi model dengan huruf besar
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items.product')
            ->where('user_id', auth()->id())
            ->paginate(2);

        return view('invoices.index', compact('invoices'));
    }


    public function create()
    {
        $products = Product::all();
        return view('invoices.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'               => 'required|string|min:10|max:100',
            'postal_code'           => 'required|digits:5',
            'products'              => 'required|array',
            'products.*.id'         => 'required|exists:products,id',
            'products.*.quantity'   => 'required|integer|min:1',
        ]);

        // Generate nomor invoice unik
        $invoiceNumber = 'INV-' . time();

        $total = 0;
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'user_id'        => auth()->id(),
            'address'        => $request->address,
            'postal_code'    => $request->postal_code,
            'total_price'    => 0,
        ]);

        foreach ($request->products as $p) {
            $product = Product::findOrFail($p['id']);
            $subtotal = $product->price * $p['quantity'];
            $total += $subtotal;

            invoice_item::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product->id,
                'quantity'   => $p['quantity'],
                'subtotal'   => $subtotal,
            ]);
        }

        $invoice->update(['total_price' => $total]);

        return redirect()
            ->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice berhasil dibuat!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items.product');
        return view('invoices.show', compact('invoice'));
    }

    public function add(Product $product)
    {
        $invoice = Invoice::firstOrCreate(
            ['user_id' => auth()->id(), 'total_price' => 0],
            [
                'invoice_number' => 'INV-' . time(),
                'address' => 'Alamat default',
                'postal_code' => '00000',
            ]
        );

        $item = $invoice->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->quantity += 1;
            $item->subtotal = $item->quantity * $product->price;
            $item->save();
        } else {
            $invoice->items()->create([
                'product_id' => $product->id,
                'quantity'   => 1,
                'subtotal'   => $product->price,
            ]);
        }

        $invoice->update([
            'total_price' => $invoice->items->sum(fn($i) => $i->subtotal),
        ]);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Produk ditambahkan ke faktur!');
    }

    public function destroy(Invoice $invoice)
    {

        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Faktur berhasil dihapus.');
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|digits:5',
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $invoice->update([
            'address' => $request->address,
            'postal_code' => $request->postal_code,
        ]);

        $total = 0;
        foreach ($request->items as $itemId => $data) {
            $item = $invoice->items()->findOrFail($itemId);
            $item->quantity = $data['quantity'];
            $item->subtotal = $item->product->price * $item->quantity;
            $item->save();

            $total += $item->subtotal;
        }

        $invoice->update(['total_price' => $total]);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Faktur berhasil diperbarui!');
    }

}
