<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceAttachmentController;

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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function () {
    Route::middleware(['guest:web'])->group(function () {
        Route::get('/register', [UserController::class, 'register'])->name('register');
        Route::get('/login', [UserController::class, 'login'])->name('login');
        Route::post('/create', [UserController::class, 'create'])->name('create');
        Route::post('/check', [UserController::class, 'check'])->name('check');
    });
    Route::middleware(['auth:web', 'history'])->group(function () {
        Route::view('/home', 'user.home')->name('home');
        Route::get('logout', [UserController::class, 'logout'])->name('logout');
        Route::resource('invoices', InvoiceController::class);
        Route::resource('section', SectionController::class);
        Route::get('sectionProduct/{id}', [SectionController::class, 'getProduct']);
        Route::resource('product', ProductController::class);
        Route::resource('archive', ArchiveController::class);
        Route::resource('attach', InvoiceAttachmentController::class);
        Route::get('sections/{id}', [InvoiceController::class, 'getPage']);
        Route::get('view/{id}', [InvoiceController::class, 'getview'])->name('view');
        Route::get('download/{id}', [InvoiceController::class, 'getDowanload'])->name('download');
        Route::get('status/{id}', [InvoiceController::class, 'edit_status'])->name('edit_status');
        Route::get('invoice_paid', [InvoiceController::class, 'invoice_paid'])->name('invoice_paid');
        Route::get('invoice_unpaid', [InvoiceController::class, 'invoice_unpaid'])->name('invoice_unpaid');
        Route::get('invoice_partical', [InvoiceController::class, 'invoice_partical'])->name('invoice_partical');
        Route::get('print_invoice/{id}', [InvoiceController::class, 'print_invoice'])->name('print');
        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::post('/report', [ReportController::class, 'Search_invoices'])->name('Search_invoices');
        Route::get('/reportcustomer', [ReportController::class, 'indexCustomer'])->name('indexCustomer');
        Route::post('/reportcustomers', [ReportController::class, 'Search_customers'])->name('Search_customer');
        Route::get('/{pages}', [AdminController::class, 'index'])->name('index');
        Route::put('update_status/{id}', [InvoiceController::class, 'update_status'])->name('update_status');
        Route::resource('person', PersonController::class)->except('index');
        Route::get('/persons/indexs', [PersonController::class, 'indexs'])->name('indexs');
        Route::resource('role', RoleController::class);
        Route::get('/roles/indexs', [RoleController::class, 'indexs'])->name('Roleindexs');
    });
});
class Service
{
    //
}
Route::get('/h', function (Service $service) {
    echo get_class($service);
});

Route::get('/h', function (Service $service) {
    echo get_class($service);
});
Route::get('/h', function (Service $service) {
    echo get_class($service);
});
