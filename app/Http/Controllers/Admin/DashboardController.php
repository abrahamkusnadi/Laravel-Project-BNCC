<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {   
        $data = [
            'total_users' => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_revenue' => Invoice::where('status', 'completed')->sum('total_price'),
            'recent_orders' => Invoice::with('user')->where('status', 'completed')
                                                    ->latest()
                                                    ->take(5)
                                                    ->get(),
        ];
        return view('admin.dashboard', compact('data'));
    }
}
