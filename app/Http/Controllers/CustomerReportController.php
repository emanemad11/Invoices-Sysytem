<?php

namespace App\Http\Controllers;

use App\Models\CustomerReport;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Invoice;


class CustomerReportController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('reports.customers_report', compact('sections'));
    }

    public function searchCustomers(Request $request)
    {
        $query = Invoice::where('section_id', $request->Section)
            ->where('product', $request->product);

        if ($request->start_at && $request->end_at) {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $query->whereBetween('invoice_Date', [$start_at, $end_at]);
        }

        $details = $query->get();
        $sections = Section::all();
        return view('reports.customers_report', compact('sections', 'details'));
    }
}
