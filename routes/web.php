<?php

use App\Http\Controllers\InvoiceAttacchmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceArchieveController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\CustomerReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/dashboard', HomeController::class);

Route::resource('invoices', InvoiceController::class);
Route::resource('Archive', InvoiceArchieveController::class);
Route::resource('sections', SectionController::class);

Route::resource('products', ProductController::class);
Route::get('/section/{id}', [InvoiceController::class, 'getProducts']);
Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit']);

Route::get('/InvoicesDetails/{id}', [InvoiceDetailController::class, 'edit']);
Route::get('/Invoice_Paid', [InvoiceController::class, 'Invoice_Paid']);
Route::get('/Invoice_UnPaid', [InvoiceController::class, 'Invoice_UnPaid']);
Route::get('/Invoice_Partial', [InvoiceController::class, 'Invoice_Partial']);
Route::get('/Print_invoice/{id}', [InvoiceController::class, 'Print_invoice']);
Route::get('/MarkAsRead_all', [InvoiceController::class, 'MarkAsRead_all']);
Route::get('/Status_show/{id}', [InvoiceController::class, 'show']);
Route::post('/Status_Update/{id}', [InvoiceController::class, 'Status_Update'])->name('Status_Update');
Route::get('export_invoices', [InvoiceController::class, 'export']);

Route::resource('invoices_report', InvoiceReportController::class);
Route::post('Search_invoices', [InvoiceReportController::class, 'Search_invoices']);
Route::resource('customers_report', CustomerReportController::class);
Route::post('Search_customers', [CustomerReportController::class, 'Search_Customers']);


Route::controller(InvoiceDetailController::class)->group(function () {
    Route::get('/view-file/{invoice_number}/{file_name}', 'viewFile');
    Route::get('/download-file/{invoice_number}/{file_name}', 'downloadFile');
    Route::post('/delete-file', 'destroy');
});

Route::post('/InvoiceAttachments', [InvoiceAttacchmentController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});

require __DIR__ . '/auth.php';
