<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Exports\InvoicesExport;
use App\Models\InvoiceAttacchment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact('invoices'));
    }

    public function create()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('invoices.add_invoice', compact('sections', 'products'));
    }

    public function store(Request $request)
    {
        $invoice = Invoice::create([
            'invoice_number'        => $request->invoice_number,
            // 'invoice_Date'          => $request->invoice_Date,
            // 'Due_date'              => $request->Due_date,
            'product'               => $request->product,
            'section_id'            => $request->Section,
            'Amount_collection'     => $request->Amount_collection,
            'Amount_Commission'     => $request->Amount_Commission,
            'Discount'              => $request->Discount,
            // 'Value_VAT'             => $request->Value_VAT,
            'Value_VAT'             => 55,
            'Rate_VAT'              => $request->Rate_VAT,
            // 'Total'                 => $request->Total,
            'Total'                 => 5555,
            'Status'                => 'غير مدفوعة',
            'Value_Status'          => 2,
            'note'                  => $request->note,
        ]);

        InvoiceDetail::create([
            'id_Invoice'     => $invoice->id,
            'invoice_number' => $request->invoice_number,
            'product'        => $request->product,
            'Section'        => $request->Section,
            'Status'         => 'غير مدفوعة',
            'Value_Status'   => 2,
            'note'           => $request->note,
            'user'           => Auth::user()->name,
        ]);

        if ($request->hasFile('pic')) {
            $attachment = $request->file('pic');
            $file_name = $attachment->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachment->move(public_path('Attachments/' . $invoice_number), $file_name);

            InvoiceAttacchment::create([
                'file_name'         => $file_name,
                'invoice_number'    => $invoice_number,
                'Created_by'        => Auth::user()->name,
                'invoice_id'        => $invoice->id,
            ]);
        }

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    public function show(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $sections = Section::all();

        return view('invoices.status_update', compact('invoice', 'sections'));
    }

    public function edit(string $id)
    {
        $invoices = Invoice::findOrFail($id);
        $sections = Section::all();

        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }

    public function update(Request $request)
    {
        $invoices = Invoice::findOrFail($request->invoice_id);

        $invoices->update([
            'invoice_number'    => $request->invoice_number,
            'invoice_Date'      => $request->invoice_Date,
            'Due_date'          => $request->Due_date,
            'product'           => $request->product,
            'section_id'        => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount'          => $request->Discount,
            'Value_VAT'         => $request->Value_VAT,
            'Rate_VAT'          => $request->Rate_VAT,
            'Total'             => $request->Total,
            'note'              => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect()->route('invoices.index');
    }



   public function destroy(Request $request){
        $invoice = Invoice::findOrFail($request->invoice_id);
        $attachment = InvoiceAttacchment::where('invoice_id', $request->invoice_id)->first();
        $id_page = $request->id_page;

        if ($id_page == 2) {
            $invoice->delete();
            session()->flash('archive_invoice', 'تم نقل الفاتورة إلى الأرشيف بنجاح.');
            return redirect('/Archive');
        }

        if ($attachment && !empty($attachment->invoice_number)) {
            Storage::disk('public_uploads')->deleteDirectory($attachment->invoice_number);
        }

        $invoice->forceDelete();
        session()->flash('delete_invoice', 'تم حذف الفاتورة بنجاح.');
        return redirect('/invoices');
    }


    public function getProducts($id)
    {
        $products = Product::where('section_id', $id)->pluck('Product_name', 'id');
        return response()->json($products);
    }

    public function updateStatusInvoice($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);

        $status = $request->Status;
        $valueStatus = $status === 'مدفوعة' ? 1 : 3;

        $invoice->update([
            'Value_Status'    => $valueStatus,
            'Status'          => $status,
            'Payment_Date'    => $request->Payment_Date,
        ]);

        InvoiceDetail::create([
            'id_Invoice'      => $request->invoice_id,
            'invoice_number'  => $request->invoice_number,
            'product'         => $request->product,
            'Section'         => $request->Section,
            'Status'          => $status,
            'Value_Status'    => $valueStatus,
            'note'            => $request->note,
            'Payment_Date'    => $request->Payment_Date,
            'user'            => Auth::user()->name,
        ]);

        session()->flash('Status_Update', 'تم تحديث حالة الفاتورة بنجاح.');
        return redirect('/invoices');
    }

    public function filterInvoices($status)
    {
        $invoices = Invoice::where('Value_Status', $status)->get();
        $viewName = 'invoices.';

        switch ($status) {
            case 1:
                $viewName .= 'invoices_paid';
                break;
            case 2:
                $viewName .= 'invoices_unpaid';
                break;
            case 3:
                $viewName .= 'invoices_partial';
                break;
            default:
                break;
        }

        return view($viewName, compact('invoices'));
    }

    public function exportOrPrintInvoice($id = null)
    {
        if ($id) {
            $invoices = Invoice::findOrFail($id);
            return view('invoices.Print_invoice', compact('invoices'));
        } else {
            return Excel::download(new InvoicesExport, 'قايمه الفواتير.xlsx');
        }
    }

    public function MarkAsRead_all(Request $request)
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }
}
