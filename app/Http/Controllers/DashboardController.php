<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == "admin") {
            $data = [
                'total_users' => User::where('role', 'user')->count(),
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
                'total_revenue' => Invoice::where('status', 'completed')->sum('total_price'),
            ];
        } else {
            $data = [
                'total_invoices' => Invoice::where('user_id', $user->id)->where('status', 'completed')->count(),
                'total_spent' => Invoice::where('user_id', $user->id)->where('status', 'completed')->sum('total_price'),
                'pending_cart' => Invoice::where('user_id', $user->id)->where('status', 'pending')->count(),
                'recent_invoices' => Invoice::where('user_id', $user->id)->where('status', 'completed')->latest()->take(3)->get(),
            ];
        }

        return view('dashboard', compact('data'));
    }
}
