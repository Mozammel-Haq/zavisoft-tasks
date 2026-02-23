<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalLine extends Model
{
    protected $fillable = [
        'journal_entry_id',
        'account_name',
        'account_type',
        'debit',
        'credit',
    ];
    protected function casts(): array
    {
        return [
            'debit'  => 'decimal:2',
            'credit' => 'decimal:2',
        ];
    }
    public function journalEntry():BelongsTo{
        return $this->belongsTo(JournalEntry::class);
    }
}
