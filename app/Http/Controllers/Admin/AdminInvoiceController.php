<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminInvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {

        $invoice->load('items.product');
        return view('admin.invoices.show', compact('invoice'));
    }
}
