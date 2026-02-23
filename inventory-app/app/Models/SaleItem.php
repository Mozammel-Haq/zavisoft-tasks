<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'unit_cost',
        'total_price',
        'total_cost',
    ];

    public function sale():BelongsTo{
        return $this->belongsTo(Sale::class);
    }
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
