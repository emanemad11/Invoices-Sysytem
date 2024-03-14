<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttacchment;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{

    public function edit($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        $details  = InvoiceDetail::where('id_Invoice', $id)->get();
        $attachments  = InvoiceAttacchment::where('invoice_id', $id)->get();
        return view('invoices.invoices_details', compact('invoices', 'details', 'attachments'));
    }

    public function destroy(Request $request)
    {
        $invoices = InvoiceAttacchment::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function get_file($invoice_number, $image_name)

    {
        $files = public_path('Attachments/' . $invoice_number . "/" . $image_name);
        return response()->download($files);
    }

    public function open_file($invoice_number, $image_name)

    {
        $files = public_path('Attachments/' . $invoice_number . "/" . $image_name);
        return response()->file($files);
    }
}
