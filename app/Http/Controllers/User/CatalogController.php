<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderByRaw('CASE WHEN stock > 0 THEN 1 ELSE 2 END ASC')
                        ->latest()
                        ->get();

        return view('user.catalog.index', compact('categories', 'products'));
    }

    public function addToInvoice(Request $request, Product $product)
    {
        if ($product->stock < 1) {
            return redirect()->back()->with('error', "Sorry, {$product->name} is out of stock!");
        }

        $invoice = Invoice::where('user_id', auth()->id())->where('status', 'pending')->first();

        if (!$invoice) {
            $today = now()->format('Ymd');
            $lastInvoice = Invoice::where('invoice_number', 'LIKE', "INV-{$today}-%")->latest()->first();
            
            if ($lastInvoice) {
                $lastSequence = (int) substr($lastInvoice->invoice_number, -4);
                $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
            } else{
                $newSequence = '0001';
            }

            $invoiceNumber = "INV-{$today}-{$newSequence}";

            $invoice = Invoice::create([
                'user_id' => auth()->id(), 
                'total_price' => 0,
                'invoice_number' => $invoiceNumber,
                'address' => 'Default Address',
                'postal_code' => '00000',
                'status' => 'pending',
            ]);
        }

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

        $product->stock -= 1;
        $product->save();

        $invoice->update([
            'total_price' => $invoice->items->sum('subtotal'),
        ]);

        return redirect()->route('user.invoices.show', $invoice->id)
            ->with('success', 'Product Added to invoice!');
    }
}
