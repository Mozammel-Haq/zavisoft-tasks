<?php

namespace App\Services;

use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\Sale;

class JournalService{


    public function recordSaleJournal(Sale $sale){

        $entry = JournalEntry::create([
            'reference_type'=>'sale',
            'reference_id'=> $sale->id,
            'entry_date'=>$sale->sale_date,
            'description' => "Sale Invoive #{$sale->invoice_number} - {$sale->customer_name}",

        ]);

        $lines = [];

            // DR - Cash Received

            if($sale->paid_amount >0){

                $lines[] = $this->line($entry->id, 'Cash / Bank','asset', debit:(float) $sale->paid_amount);
            }

            //DR - Amount Still Owed by Customer

            if($sale->due_amount > 0){
                $lines[] = $this->line($entry->id, 'Accounts Receivable','asset', debit:(float) $sale->due_amount);
            }


            // DR - Discount as Expense

            if($sale->discount >0){
                $lines[] = $this->line($entry->id, 'Sale Discount','expense', debit:(float) $sale->discount);
            }

            // CR - Gross Sell Revenue before Discount

            if($sale->gross_amount > 0){
                $lines[] = $this->line($entry->id, 'Sale Revenue','income', credit:(float) $sale->gross_amount);
            }

            // CR - Vat as Liability

            if($sale->vat_amount > 0){
                $lines[] = $this->line($entry->id, 'VAT Payable','liability', credit:(float) $sale->vat_amount);
            }

        // DR - COGS as expense

        $lines[] = $this->line($entry->id, 'Cost of Goods Sold', 'expense',
            debit: (float) $sale->cogs
        );

        // CR - Inventory Reduced

        $lines[] = $this->line($entry->id, 'Inventory', 'asset',
            credit: (float) $sale->cogs
        );

        JournalLine::insert($lines);
        return $entry->load('lines');
    }

    private function line(
        int    $entryId,
        string $accountName,
        string $accountType,
        float  $debit  = 0,
        float  $credit = 0,
    ): array {
        return [
            'journal_entry_id' => $entryId,
            'account_name'     => $accountName,
            'account_type'     => $accountType,
            'debit'            => $debit,
            'credit'           => $credit,
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
    }


}
