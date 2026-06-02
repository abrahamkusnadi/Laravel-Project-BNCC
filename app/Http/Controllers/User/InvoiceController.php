<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\invoice_item;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(5);

        return view('user.invoices.index', compact('invoices'));
    }

    public function currentCart()
    {
        $invoice = Invoice::where('user_id', auth()->id())->where('status', 'pending')->first();

        if($invoice) {
            return redirect()->route('user.invoices.show', $invoice->id);
        }

        return redirect()->route('user.catalog')->with('error', 'Your cart is empty. Start shopping now!');
    }

    public function addToCart(Request $request, Product $product)
    {
        $invoice = Invoice::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'pending'],
            ['total_price' => 0]
        );

        $inputQty = $request->input('quantity', 1);

        $invoiceItem = $invoice->items()->where('product_id', $product->id)->first();

        if ($invoiceItem) {
            $invoiceItem->quantity += $inputQty;
            $invoiceItem->subtotal = $invoiceItem->quantity * $product->price;
            $invoiceItem->save();
            
        } else {
            $invoice->items()->create([
                'product_id' => $product->id,
                'quantity' => $inputQty,
                'subtotal' => $inputQty * $product->price
            ]);
        }

        $invoice->update([
            'total_price' => $invoice->items()->sum('subtotal')
        ]);

        return redirect()->back()->with('success', 'Product successfully added to your cart!');
    }

    public function print(Invoice $invoice)
    {
        if ($invoice->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->load('items.product');
        return view('user.invoices.print', compact('invoice'));
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->load('items.product');
        return view('user.invoices.show', compact('invoice'));
    }


    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($invoice->status === 'completed') {
            return redirect()->route('user.invoices.index')->with('error', 'This invoice has already been completed.');
        }

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
            $product = $item->product;

            $newQty = $data['quantity'];
            $oldQty = $item->quantity;
            $stockChange = $newQty - $oldQty;

            if ($stockChange > 0 && $product->stock < $stockChange) {
                return redirect()->back()->with('error', "Sorry, not enough stock for {$product->name}. Only {$product->stock} left!");
            }  

            $product->stock -= $stockChange;
            $product->save();

            $item->quantity = $newQty;
            $item->subtotal = $newQty * $product->price;
            $item->save();

            $total += $item->subtotal;
        }

        $invoice->update([
            'total_price' => $total,
            'status' => 'completed'
        ]);

        return redirect()->route('user.invoices.index')
            ->with('success', 'Checkout successful! Your order is now completed.');
    }
    public function destroy(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($invoice->status === 'pending') {
            foreach ($invoice->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
        }

        $invoice->delete();

        return redirect()->route('user.invoices.index')->with('success', 'Invoice cancelled/deleted successfully.');
    }
}