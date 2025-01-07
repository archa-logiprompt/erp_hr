<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClentController;
use App\Http\Controllers\Clienetreport;
use App\Http\Controllers\ClientinvoiceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentInvoiceController;
use App\Http\Controllers\GstController;
// use App\Http\Controllers\CenterController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\Clientreport;
use App\Http\Controllers\ExpenseHeadController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpensereportController;
use App\Http\Controllers\ExpReportController;


use App\Http\Controllers\GstreportController;
use App\Http\Controllers\IncomedetailsController;
use App\Http\Controllers\IncomeHeadController;
use App\Http\Controllers\IncomereportController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\IncomeHead;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// login
Route::get('/', [AdminController::class, 'login'])->name('login');
Route::post('/admin/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

Route::middleware([AdminMiddleware::class])->group(function () {

    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');



    // country list

    // Route::get('form', [CountryController::class, 'index']);
    // Route::get('/admin/courses/create',[CountryController::class,'index'])->name('admin.student.create');


    Route::get('/admin/courses', [CourseController::class, 'index'])->name('admin.course.index');
    Route::get('/admin/courses/create', [CourseController::class, 'create'])->name('admin.course.create');
    Route::post('/admin/courses/store', [CourseController::class, 'store'])->name('admin.course.store');
    Route::get('/admin/courses/destroy/{id}', [CourseController::class, 'destroy'])->name('admin.course.destroy');
    Route::get('/admin/courses/edit/{id}', [CourseController::class, 'edit'])->name('admin.course.edit');
    Route::post('/admin/courses/update/{id}', [CourseController::class, 'update'])->name('admin.course.update');


    // Student
    Route::get('/admin/students', [StudentController::class, 'index'])->name('admin.student.index');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->name('admin.student.create');
    Route::post('/admin/students/store', [StudentController::class, 'store'])->name('admin.student.store');
    Route::get('/admin/students/destroy/{id}', [StudentController::class, 'destroy'])->name('admin.student.destroy');
    Route::get('/admin/students/edit/{id}', [StudentController::class, 'edit'])->name('admin.student.edit');
    Route::put('/admin/students/update/{id}', [StudentController::class, 'update'])->name('admin.student.update');


    // client

    Route::get('/admin/client', [ClentController::class, 'index'])->name('admin.client.index');
    Route::get('/admin/client/create', [ClentController::class, 'create'])->name('admin.client.create');
    Route::post('/admin/client/store', [ClentController::class, 'store'])->name('admin.client.store');
    Route::get('/admin/client/destroy/{id}', [ClentController::class, 'destroy'])->name('admin.client.destroy');
    Route::get('/admin/client/edit/{id}', [ClentController::class, 'edit'])->name('admin.client.edit');
    Route::post('/admin/client/update/{id}', [ClentController::class, 'update'])->name('admin.client.update');

    // project
    Route::get('/admin/project', [ProjectController::class, 'index'])->name('admin.project.index');
    Route::get('/admin/project/create', [ProjectController::class, 'create'])->name('admin.project.create');
    Route::post('/admin/project/store', [ProjectController::class, 'store'])->name('admin.project.store');
    Route::get('/admin/project/destroy/{id}', [ProjectController::class, 'destroy'])->name('admin.project.destroy');
    Route::get('/admin/project/edit/{id}', [ProjectController::class, 'edit'])->name('admin.project.edit');
    Route::post('/admin/project/update/{id}', [ProjectController::class, 'update'])->name('admin.project.update');

    // student invoice

    Route::get('/admin/studentinvoice', [StudentInvoiceController::class, 'index'])->name('admin.studentinvoice.index');
    Route::get('/admin/studentinvoice/create', [StudentInvoiceController::class, 'create'])->name('admin.studentinvoice.create');
    Route::post('/admin/studentinvoice/store', [StudentInvoiceController::class, 'store'])->name('admin.studentinvoice.store');
    Route::get('/admin/studentinvoice/destroy/{id}', [StudentInvoiceController::class, 'destroy'])->name('admin.studentinvoice.destroy');
    Route::get('/admin/studentinvoice/edit/{id}', [StudentInvoiceController::class, 'edit'])->name('admin.studentinvoice.edit');
    Route::put('/admin/studentinvoice/update/{id}', [StudentInvoiceController::class, 'update'])->name('admin.studentinvoice.update');
    Route::get('/admin/studentinvoice/view/{id}', [StudentInvoiceController::class, 'view'])->name('admin.studentinvoice.view');
    Route::get('/admin/studentinvoice/fetch-fee-details/{id}', [StudentInvoiceController::class, 'getFeeDetails'])->name('admin.studentinvoice.fetchFeeDetails');
    Route::get('/admin/studentinvoice/getFeePercentage/{id}', [StudentInvoiceController::class, 'getFeePercentage'])->name('admin.studentinvoice.fetchFeeDetail');
    Route::get('/admin/studentinvoice/get-tax-details/{id}', [StudentInvoiceController::class, 'getTaxDetails'])->name('admin.studentinvoice.fetchtaxDetails');



    // studentinvoicepdf
    Route::get('/admin/studentinvoicepdf', [StudentInvoiceController::class, 'view'])->name('admin.studentinvoicepdf.index');

    // gst
    Route::get('/admin/gst', [GstController::class, 'index'])->name('admin.gst.index');
    Route::get('/admin/gst/create', [GstController::class, 'create'])->name('admin.gst.create');
    Route::post('/admin/gst/store', [GstController::class, 'store'])->name('admin.gst.store');
    Route::get('/admin/gst/destroy/{id}', [GstController::class, 'destroy'])->name('admin.gst.destroy');
    Route::get('/admin/gst/edit/{id}', [GstController::class, 'edit'])->name('admin.gst.edit');
    Route::post('/admin/gst/update/{id}', [GstController::class, 'update'])->name('admin.gst.update');
    // FeeController
    Route::get('/admin/fee', [FeeController::class, 'index'])->name('admin.fee.index');
    Route::get('/admin/fee/create', [FeeController::class, 'create'])->name('admin.fee.create');
    Route::post('/admin/fee/store', [FeeController::class, 'store'])->name('admin.fee.store');
    Route::delete('/admin/fee/destroy/{id}', [FeeController::class, 'destroy'])->name('admin.fee.destroy');
    Route::get('/admin/fee/edit/{id}', [FeeController::class, 'edit'])->name('admin.fee.edit');
    Route::put('/admin/fee/update/{id}', [FeeController::class, 'update'])->name('admin.fee.update');


    // BalanceController
    Route::get('/admin/balance/create', [BalanceController::class, 'create'])->name('admin.balance.create');
    Route::post('/admin/balance/store', [BalanceController::class, 'store'])->name('admin.balance.store');
   Route::get('/admin/balance/view/{id}', [BalanceController::class, 'view'])->name('admin.balance.view');
    Route::any('/admin/balance/report', [BalanceController::class, 'report'])->name('admin.balance.report');






    // TaxMaster
    Route::get('/admin/tax', [TaxController::class, 'index'])->name('admin.tax.index');
    Route::get('/admin/tax/create', [TaxController::class, 'create'])->name('admin.tax.create');
    Route::post('/admin/tax/store', [TaxController::class, 'store'])->name('admin.tax.store');
    Route::get('/admin/tax/destroy/{id}', [TaxController::class, 'destroy'])->name('admin.tax.destroy');
    Route::get('/admin/tax/edit/{id}', [TaxController::class, 'edit'])->name('admin.tax.edit');
    Route::put('/admin/tax/update/{id}', [TaxController::class, 'update'])->name('admin.tax.update');

    // gstreport
    Route::get('/admin/gstreport', [GstreportController::class, 'index'])->name('admin.gstreport.index');
    Route::get('/admin/gstreport/create', [GstreportController::class, 'create'])->name('admin.gstreport.create');
    Route::post('/admin/gstreport/store', [GstreportController::class, 'store'])->name('admin.gstreport.store');
    Route::get('/admin/gstreport/destroy/{id}', [GstreportController::class, 'destroy'])->name('admin.gstreport.destroy');
    Route::get('/admin/gstreport/edit/{id}', [GstreportController::class, 'edit'])->name('admin.gstreport.edit');
    Route::post('/admin/gstreport/update/{id}', [GstreportController::class, 'update'])->name('admin.gstreport.update');


    // General Settings invoice

    Route::get('/admin/generalsettings', [GeneralSettingsController::class, 'index'])->name('admin.generalsettings.index');
    Route::get('/admin/generalsettings/create', [GeneralSettingsController::class, 'create'])->name('admin.generalsettings.create');
    Route::post('/admin/generalsettings/store', [GeneralSettingsController::class, 'store'])->name('admin.generalsettings.store');
    Route::get('/admin/generalsettings/destroy/{id}', [GeneralSettingsController::class, 'destroy'])->name('admin.generalsettings.destroy');
    Route::get('/admin/generalsettings/edit/{id}', [GeneralSettingsController::class, 'edit'])->name('admin.generalsettings.edit');
    Route::post('/admin/generalsettings/update/{id}', [GeneralSettingsController::class, 'update'])->name('admin.generalsettings.update');


    // clientinvoice
    Route::get('/admin/clientinvoice', [ClientinvoiceController::class, 'index'])->name('admin.clientinvoice.index');
    Route::get('/admin/clientinvoice/create', [ClientinvoiceController::class, 'create'])->name('admin.clientinvoice.create');
    Route::post('/admin/clientinvoice/store', [ClientinvoiceController::class, 'store'])->name('admin.clientinvoice.store');
    Route::get('/admin/clientinvoice/destroy/{id}', [ClientinvoiceController::class, 'destroy'])->name('admin.clientinvoice.destroy');
    Route::get('/admin/clientinvoice/edit/{id}', [ClientinvoiceController::class, 'edit'])->name('admin.clientinvoice.edit');
    Route::post('/admin/clientinvoice/update/{id}', [ClientinvoiceController::class, 'update'])->name('admin.clientinvoice.update');
    // client invoice pdf
    Route::get('/admin/invoicePdf/{id}', [ClientinvoiceController::class, 'view'])->name('admin.invoicepdf.index');

    // client invoice reports

    Route::get('/admin/clientReport', [Clientreport::class, 'index'])->name('admin.clientReport.index');

    // center
    Route::get('/admin/center', [CenterController::class, 'index'])->name('admin.center.index');
    Route::get('/admin/center/create', [CenterController::class, 'create'])->name('admin.center.create');
    Route::post('/admin/center/store', [CenterController::class, 'store'])->name('admin.center.store');
    Route::get('/admin/center/destroy/{id}', [CenterController::class, 'destroy'])->name('admin.center.destroy');
    Route::get('/admin/center/edit/{id}', [CenterController::class, 'edit'])->name('admin.center.edit');
    Route::put('/admin/center/update/{id}', [CenterController::class, 'update'])->name('admin.center.update');


    // income head
    Route::get('/admin/incomehead', [IncomeHeadController::class, 'index'])->name('admin.incomehead.index');
    Route::get('/admin/incomehead/create', [IncomeHeadController::class, 'create'])->name('admin.incomehead.create');
    Route::post('/admin/incomehead/store', [IncomeHeadController::class, 'store'])->name('admin.incomehead.store');
    Route::get('/admin/incomehead/destroy/{id}', [IncomeHeadController::class, 'destroy'])->name('admin.incomehead.destroy');
    Route::get('/admin/incomehead/edit/{id}', [IncomeHeadController::class, 'edit'])->name('admin.incomehead.edit');
    Route::post('/admin/incomehead/update/{id}', [IncomeHeadController::class, 'update'])->name('admin.incomehead.update');

    // income details
    Route::get('/admin/incomedetails', [IncomedetailsController::class, 'index'])->name('admin.incomedetails.index');
    Route::get('/admin/incomedetails/create', [IncomedetailsController::class, 'create'])->name('admin.incomedetails.create');
    Route::post('/admin/incomedetails/store', [IncomedetailsController::class, 'store'])->name('admin.incomedetails.store');
    Route::get('/admin/incomedetails/destroy/{id}', [IncomedetailsController::class, 'destroy'])->name('admin.incomedetails.destroy');
    Route::get('/admin/incomedetails/edit/{id}', [IncomedetailsController::class, 'edit'])->name('admin.incomedetails.edit');
    Route::post('/admin/incomedetails/update/{id}', [IncomedetailsController::class, 'update'])->name('admin.incomedetails.update');

    // income reports
    Route::get('/admin/incomeReport', [IncomereportController::class, 'index'])->name('admin.incomeReport.index');
Route::get('/admin/expenseReport', [ExpensereportController::class, 'index'])->name('admin.expenseReport.index');
Route::get('/admin/expReport', [ExpReportController::class, 'index'])->name('admin.expReport.index');


    // expense head
    Route::get('/admin/expensehead', [ExpenseHeadController::class, 'index'])->name('admin.expensehead.index');
    Route::get('/admin/expensehead/create', [ExpenseHeadController::class, 'create'])->name('admin.expensehead.create');
    Route::post('/admin/expensehead/store', [ExpenseHeadController::class, 'store'])->name('admin.expensehead.store');
    Route::get('/admin/expensehead/destroy/{id}', [ExpenseHeadController::class, 'destroy'])->name('admin.expensehead.destroy');
    Route::get('/admin/expensehead/edit/{id}', [ExpenseHeadController::class, 'edit'])->name('admin.expensehead.edit');
    Route::post('/admin/expensehead/update/{id}', [ExpenseHeadController::class, 'update'])->name('admin.expensehead.update');


    // expnse
    Route::get('/admin/expense', [ExpenseController::class, 'index'])->name('admin.expense.index');
    Route::get('/admin/expense/create', [ExpenseController::class, 'create'])->name('admin.expense.create');
    Route::post('/admin/expense/store', [ExpenseController::class, 'store'])->name('admin.expense.store');
    Route::delete('/admin/expense/destroy/{id}', [ExpenseController::class, 'destroy'])->name('admin.expense.destroy');
    Route::get('/admin/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('admin.expense.edit');
    Route::post('/admin/expense/update/{id}', [ExpenseController::class, 'update'])->name('admin.expense.update');



    //Department
    Route::get('/admin/department', [DepartmentController::class, 'index'])->name('admin.gstreport.index');
    // Route::get('/admin/gstreport/create', [GstreportController::class, 'create'])->name('admin.gstreport.create');
    // Route::post('/admin/gstreport/store', [GstreportController::class, 'store'])->name('admin.gstreport.store');
    // Route::get('/admin/gstreport/destroy/{id}', [GstreportController::class, 'destroy'])->name('admin.gstreport.destroy');
    // Route::get('/admin/gstreport/edit/{id}', [GstreportController::class, 'edit'])->name('admin.gstreport.edit');
    // Route::post('/admin/gstreport/update/{id}', [GstreportController::class, 'update'])->name('admin.gstreport.update');
});
