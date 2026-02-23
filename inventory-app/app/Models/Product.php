<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'purchase_price',
        'sell_price',
        'opening_stock',
        'current_stock',
    ];
    protected function casts():array{
        return [
            'purchase_price' => 'decimal:2',
            'sell_price' => 'decimal:2'
        ];
    }

    public function sellItems(){
        return $this->hasMany(SaleItem::class);
    }

    // Check if product has enough stock for a sale
    public function hasStock(int $quantity):bool{
        return $this->current_stock >= $quantity;
    }
}
