<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    public function index()
    {
        return view('reports.invoices_report');
    }
    public function searchInvoices(Request $request)
    {
        $rdio = $request->rdio;

        if ($rdio == 1) {
            if ($request->type && $request->start_at == '' && $request->end_at == '') {
                $details = Invoice::where('Status', $request->type)->get();
                $type = $request->type;
            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $details = Invoice::whereBetween('invoice_Date', [$start_at, $end_at])
                    ->where('Status', $request->type)
                    ->get();
            }

            return view('reports.invoices_report', compact('type', 'start_at', 'end_at', 'details'));
        } else {
            $details = Invoice::where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_report', compact('details'));
        }
    }

}
