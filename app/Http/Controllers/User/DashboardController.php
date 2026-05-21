<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'total_invoices' => Invoice::where('user_id', auth()->id())->where('status', 'completed')->count(),
            'total_spent' => Invoice::where('user_id', auth()->id())->where('status', 'completed')->sum('total_price'),
            'pending_cart' => Invoice::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'recent_invoices' => Invoice::where('user_id', auth()->id())->where('status', 'completed')->latest()->take(3)->get(),
        ];

        return view('user.dashboard', compact('data'));
    }
}
