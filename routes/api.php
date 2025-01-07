<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentInvoiceController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/admin/studentinvoice/get-tax-details/{id}', [StudentInvoiceController::class, 'getTaxDetails'])->name('admin.studentinvoice.fetchtaxDetails');
Route::get('/admin/studentinvoice/fetch-fee-details/{id}', [StudentInvoiceController::class, 'getFeeDetails'])->name('admin.studentinvoice.fetchFeeDetails');
Route::get('/admin/studentinvoice/getFeePercentage/{id}', [StudentInvoiceController::class, 'getFeePercentage'])->name('admin.studentinvoice.fetchFeeDetails');

