<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalEntry extends Model
{
    protected $fillable = [
        'reference_type',
        'reference_id',
        'entry_date',
        'description',
    ];
    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
        ];
    }
    public function lines():HasMany
    {
        return $this->hasMany(JournalLine::class);
    }

     // Verify DR = CR
    public function isBalanced(): bool
    {
        $totalDebit  = $this->lines->sum('debit');
        $totalCredit = $this->lines->sum('credit');
        return round($totalDebit, 2) === round($totalCredit, 2);
    }

}
