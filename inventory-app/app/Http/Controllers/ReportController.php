<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

use function Symfony\Component\Clock\now;

class ReportController extends Controller
{
    public function financial(Request $request){
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to = $request->get('to',now()->toDateString());


        // DateWise Report

        $dailyReport = Sale::selectRaw("
            sale_date,
            COUNT(*) AS total_transactions,
            SUM(gross_amount) AS gross_sales,
            SUM(discount) AS total_discount,
            SUM(vat_amount) AS total_vat,
            SUM(net_amount) AS net_sales,
            SUM(paid_amount) AS total_collected,
            SUM(due_amount) AS total_due,
            SUM(cogs) AS total_expense,
            SUM(net_amount) - SUM(cogs) AS gross_profit
        ")->whereBetween('sale_date',[$from,$to])->groupBy('sale_date')->orderBy('sale_date','asc')->get();


        // Summary for the Entire Period

        $summary = [
            'total_sell'    => $dailyReport->sum('net_sales'),
            'total_expense' => $dailyReport->sum('total_expense'),
            'gross_profit'  => $dailyReport->sum('gross_profit'),
            'total_vat'     => $dailyReport->sum('total_vat'),
            'total_discount'=> $dailyReport->sum('total_discount'),
            'total_due'     => $dailyReport->sum('total_due'),
            'total_collected'=> $dailyReport->sum('total_collected'),
        ];

        return view('reports.financial', compact(
            'dailyReport', 'summary', 'from', 'to'
        ));
    }
}
