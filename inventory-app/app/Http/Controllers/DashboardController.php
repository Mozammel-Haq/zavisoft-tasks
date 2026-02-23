<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $stats = [
            'total_products' => Product::count(),
            'total_sales' => Sale::count(),
            'total_revenue' => Sale::sum('net_amount'),
            'total_due' => Sale::sum('due_amount'),
            'low_stock' => Product::where('current_stock','<',10),
            'today_sales' => Sale::whereDate('sale_date',today())->sum('net_amount')
        ];

        $recent_sales = Sale::with('items.product')->latest()->take(5)->get();

        return view('dashboard',compact('stats','recent_sales'));
    }
}
