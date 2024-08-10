<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\InvoiceAttacchment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{
    public function edit($id)
    {
        $invoices = Invoice::findOrFail($id);
        $details = InvoiceDetail::where('id_invoice', $id)->get();
        $attachments = InvoiceAttacchment::where('invoice_id', $id)->get();

        return view('invoices.invoices_details', compact('invoices', 'details', 'attachments'));
    }

    public function destroy(Request $request)
    {
        $attachment = InvoiceAttacchment::findOrFail($request->id_file);
        $filePath = "{$request->invoice_number}/{$request->file_name}";

        $attachment->delete();
        Storage::disk('public_uploads')->delete($filePath);

        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function downloadFile($invoice_number, $image_name)
    {
        return response()->download(public_path("Attachments/{$invoice_number}/{$image_name}"));
    }

    public function viewFile($invoice_number, $image_name)
    {
        return response()->file(public_path("Attachments/{$invoice_number}/{$image_name}"));
    }
}
