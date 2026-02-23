<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable =[
        'invoice_number',
        'customer_name',
        'sale_date',
        'gross_amount',
        'discount',
        'vat_rate',
        'vat_amount',
        'net_amount',
        'paid_amount',
        'due_amount',
        'cogs',
        'status',
    ];
    protected function casts(): array
    {
        return [
            'sale_date'    => 'date',
            'gross_amount' => 'decimal:2',
            'discount'     => 'decimal:2',
            'vat_amount'   => 'decimal:2',
            'net_amount'   => 'decimal:2',
            'paid_amount'  => 'decimal:2',
            'due_amount'   => 'decimal:2',
            'cogs'         => 'decimal:2',
        ];
    }

    public function items():HasMany{
        return $this->hasMany(SaleItem::class);
    }

    public function journalEntry(){
        return $this->hasOne(JournalEntry::class,'reference_id')->where('reference_type','sale');
    }

    public function getStatusColorAttribute(){
        return match($this->status){
            'paid'    => '#2ec4b6',
            'partial' => '#f5c842',
            'due'     => '#e85d6a',
        };
    }
}
