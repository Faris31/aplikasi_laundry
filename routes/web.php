<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

// Route::get('/', function () {
//     return view('welcome');
// });

// route login
Route::get('/', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('login', [\App\Http\Controllers\LoginController::class, 'actionLogin'])->name('login.action');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// group dasboard
Route::middleware('auth')->group(function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::middleware(['AdminOperator'])->group(function () {
        Route::get('admin', [DashboardController::class, 'admin'])->name('admin.index');

        //route user
        Route::get('operator', [DashboardController::class, 'operator'])->name('operator.index');
        Route::resource('user', \App\Http\Controllers\UserController::class);
        Route::post('user/store', [App\Http\Controllers\UserController::class,'store'])->name('user.store');
        Route::get('user/edit/{id}',[\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::put('user/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');

        //route service
        Route::resource('service', \App\Http\Controllers\ServiceController::class);
        Route::get('service/index', [\App\Http\Controllers\ServiceController::class]);
        Route::get('service/edit/{id}', [\App\Http\Controllers\ServiceController::class, 'edit'])->name('service.edit');
        Route::PUT('service/update/{id}', [\App\Http\Controllers\ServiceController::class, 'update'])->name('service.update');


        //route pelanggan
        Route::resource('pelanggan', \App\Http\Controllers\CustomerController::class);
        Route::get('pelanggan/edit/{id}',[\App\Http\Controllers\CustomerController::class, 'edit'])->name('pelanggan.edit');
        Route::put('pelanggan/update/{id}', [\App\Http\Controllers\CustomerController::class, 'update'])->name('pelanggan.update');
    });

    Route::middleware(['Operator'])->group(function () {
        // route transaksi
        Route::get('transaksi/index', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transaksi.index');
        Route::get('transaksi/create', [\App\Http\Controllers\TransactionController::class,'create'])->name('transaksi.form_transaksi');
        Route::get('transaksi/{id}', [\App\Http\Controllers\TransactionController::class, 'show'])->name('transaksi.show');
        Route::delete('transaksi/{id}', [TransactionController::class, 'destroy'])->name('transaksi.destroy');
        Route::get('/transaksi/print/{transaksi}', [TransactionController::class, 'print'])->name('transaksi.print');
        Route::get('get-all-data-orders', [TransactionController::class, 'getAllDataOrders'])->name('transaksi.getAllDataOrders');
        Route::put('/orders/{id}/status', [TransactionController::class, 'pickupLaundry'])->name('transaksi.pickupLaundry');
        Route::post('/transaksi/store', [\App\Http\Controllers\TransactionController::class, 'OrderStore'])->name('transaksi.OrderStore');
    });

    Route::middleware(['pimpinan'])->group(function () {
        // route report
        Route::get("report", [App\Http\Controllers\ReportController::class, 'report'])->name('report.index');
        Route::post("report", [App\Http\Controllers\ReportController::class, 'reportFilter'])->name('reportFilter');
        Route::get("/report/print/{report}", [App\Http\Controllers\ReportController::class, 'printLaporan'])->name('report.print');
    });
});
