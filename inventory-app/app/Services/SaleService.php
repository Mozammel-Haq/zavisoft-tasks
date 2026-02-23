<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class SaleService{

public function __construct(private readonly JournalService $journalService)
{}

public function processSale($data){
    return DB::transaction(function() use ($data){

        $product = Product::lockForUpdate()->findOrFail($data['product_id']);

        // Guard - Check Stock

        if(!$product->hasStock((int) $data['quantity'])){
            throw new \RuntimeException(
               "Insufficient stock. Available: {$product->current_stock} units, " .
                    "Requested: {$data['quantity']} units."
            );
        }

        // Calculate Financials

        $quantity     = (int)   $data['quantity'];
        $grossAmount  = $quantity * (float) $product->sell_price;
        $discount     = (float) ($data['discount'] ?? 0);
        $netBeforeVat = $grossAmount - $discount;
        $vatRate      = (float) ($data['vat_rate'] ?? 5);
        $vatAmount    = round($netBeforeVat * ($vatRate / 100), 2);
        $netAmount    = round($netBeforeVat + $vatAmount, 2);
        $paidAmount   = (float) $data['paid_amount'];
        $dueAmount    = round(max(0, $netAmount - $paidAmount), 2);
        $cogs         = $quantity * (float) $product->purchase_price;

        $status =match(true){
            $paidAmount >= $netAmount => 'paid',
            $paidAmount > 0 => 'partial',
            default => 'due',
        };

        // create Sale

        $sale = Sale::create([

                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'customer_name'  => $data['customer_name'] ?? 'Walk-in Customer',
                'sale_date'      => $data['sale_date'] ?? now()->toDateString(),
                'gross_amount'   => $grossAmount,
                'discount'       => $discount,
                'vat_rate'       => $vatRate,
                'vat_amount'     => $vatAmount,
                'net_amount'     => $netAmount,
                'paid_amount'    => $paidAmount,
                'due_amount'     => $dueAmount,
                'cogs'           => $cogs,
                'status'         => $status,

        ]);

        // create Sale Item

        SaleItem::create([
                'sale_id'     => $sale->id,
                'product_id'  => $product->id,
                'quantity'    => $quantity,
                'unit_price'  => $product->sell_price,
                'unit_cost'   => $product->purchase_price,
                'total_price' => $grossAmount,
                'total_cost'  => $cogs,
        ]);


        // Stock Reduction

        Product::decrement('current_stock',$quantity);

        // Create Journal Entries

        $this->journalService->recordSaleJournal($sale);

        return $sale;

    });
}

}
