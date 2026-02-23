<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(private readonly SaleService $saleService){}

    public function index(){
        $sales = Sale::with('items.product')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }
    public function create(){
        $product =Product::where('current_stock','>',0)->orderBy('name')->get();
        return view('sales.create', compact('products'));
    }
    public function store(Request $request){
        $valid = $request->validate([
            'product_id'    => ['required', 'exists:products,id'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'quantity'      => ['required', 'integer', 'min:1'],
            'discount'      => ['nullable', 'numeric', 'min:0'],
            'vat_rate'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'paid_amount'   => ['required', 'numeric', 'min:0'],
            'sale_date'     => ['nullable', 'date'],
        ]);

        try {
            $sale = $this->saleService->processSale($valid);
            return redirect()
                ->route('sales.show', $sale)
                ->with('success', "Sale recorded! Invoice: {$sale->invoice_number}");
        } catch (\RuntimeException $e) {
             return back()
                ->withErrors(['quantity' => $e->getMessage()])
                ->withInput();
        }
    }
    public function show(Sale $sale){
        $sale->load('item.product','JournalEntry.lines');
        return view('sales.show', compact('sale'));
    }
}
