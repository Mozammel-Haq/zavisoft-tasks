<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->paginate(10);
        return view('product.index',compact('products'));
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){
        $valid = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'sku'            => ['nullable', 'string', 'unique:products,sku'],
            'description'    => ['nullable', 'string'],
            'purchase_price' => ['required', 'numeric', 'min:0.01'],
            'sell_price'     => ['required', 'numeric', 'min:0.01'],
            'opening_stock'  => ['required', 'integer', 'min:0'],
        ]);

        // current_stock = opening_stock
        $valid['current_stock'] = $valid['opening_stock'];

        Product::create($valid);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    public function show(Product $product){
        $product->load('sellItems.sale');
        return view('products.show',compact('product'));
    }

    public function edit(Product $product){
        return view('products.edit',compact('product'));
    }

    public function update(Request $request, Product $product){

        $valid = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'sku'            => ['nullable', 'string', 'unique:products,sku,' . $product->id],
            'description'    => ['nullable', 'string'],
            'purchase_price' => ['required', 'numeric', 'min:0.01'],
            'sell_price'     => ['required', 'numeric', 'min:0.01'],
        ]);

        $product->update($valid);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');

    }
}
