<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceArchieveController extends Controller
{
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive_invoices', compact('invoices'));
    }

    public function update(Request $request)
    {
        $id = $request->invoice_id;
        Invoice::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }

    public function destroy(Request $request)
    {
        Invoice::withTrashed()->where('id', $request->invoice_id)->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/Archive');
    }

}
