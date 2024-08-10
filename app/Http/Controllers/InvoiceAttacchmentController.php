<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttacchment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttacchmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|mimes:pdf,jpeg,png,jpg',
        ]);

        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();

        $attachment = InvoiceAttacchment::create([
            'file_name' => $file_name,
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $request->invoice_id,
            'Created_by' => Auth::user()->name,
        ]);

        $file->move(public_path('Attachments/' . $request->invoice_number), $file_name);

        session()->flash('Add', 'تم إضافة المرفق بنجاح');
        return back();
    }

}
