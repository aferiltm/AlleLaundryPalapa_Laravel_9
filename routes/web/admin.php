<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PriceListController;
use App\Http\Controllers\Admin\PriceListKiloanController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\ComplaintSuggestionController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\Transaction\TransactionController;
use App\Http\Controllers\Admin\Transaction\PrintTransactionController;
use App\Http\Controllers\Admin\Transaction\TransactionSessionController;

Route::get('/', [DashboardController::class, 'index'])->name('index');

// Rute untuk sesi transaksi
Route::group(['prefix' => 'admin/transactions/session', 'as' => 'admin.transactions.session.'], function () {
    Route::post('/store', [TransactionSessionController::class, 'store'])->name('store'); // Menyimpan transaksi ke sesi
    Route::delete('/destroy/{rowId}', [TransactionSessionController::class, 'destroy'])->name('destroy'); // Menghapus transaksi dari sesi
});

Route::group([
    'prefix' => 'transactions',
    'as' => 'transactions.',
], function () {
    Route::get('/create', [TransactionController::class, 'create'])->name('create');
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show');
    Route::patch('/{transaction}', [TransactionController::class, 'update'])->name('update');

    // Route::post('/session', [TransactionSessionController::class, 'store'])->name('session.store');
    Route::post('session/store/satuan', [TransactionSessionController::class, 'storeSatuan'])->name('session.store.satuan');
    Route::post('session/store/kiloan', [TransactionSessionController::class, 'storeKiloan'])->name('session.store.kiloan');
    Route::get('/session/{rowId}', [TransactionSessionController::class, 'destroy'])->name('session.destroy');

    Route::get('/print/{transaction}', [PrintTransactionController::class, 'index'])->name('print.index');
    Route::post('/update-status', [TransactionController::class, 'updateStatus'])->name('updateStatus');
});

Route::post('/items', [ItemController::class, 'store'])->name('items.store');

Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');



Route::group([
    'prefix' => 'vouchers',
    'as' => 'vouchers.',
], function () {
    Route::get('/', [VoucherController::class, 'index'])->name('index');
    Route::post('/', [VoucherController::class, 'store'])->name('store');
    Route::patch('/{voucher}', [VoucherController::class, 'toggleStatus'])->name('toggleStatus');
    Route::put('/{voucher}', [VoucherController::class, 'update'])->name('update');
});

Route::group([
    'prefix' => 'complaint-suggestions',
    'as' => 'complaint-suggestions.',
], function () {
    Route::get('/', [ComplaintSuggestionController::class, 'index'])->name('index');
    Route::get('/{complaintSuggestion}', [ComplaintSuggestionController::class, 'show'])->name('show');
    Route::patch('/{complaintSuggestion}', [ComplaintSuggestionController::class, 'update'])->name('update');
});

Route::group([
    'prefix' => 'reports',
    'as' => 'reports.',
], function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::post('/print', [ReportController::class, 'print'])->name('print');
    Route::post('/get-month', [ReportController::class, 'getMonth'])->name('get-month');
});


Route::group([
    'prefix' => 'service-types',
    'as' => 'service-types.',
], function () {
    Route::get('/{serviceType}', [ServiceTypeController::class, 'show'])->name('show');
    Route::patch('/{serviceType}', [ServiceTypeController::class, 'update'])->name('update');
});

Route::group([
    'prefix' => 'review',
    'as' => 'review.',
], function () {
    Route::get('/', [ReviewController::class, 'index'])->name('index');
    Route::get('/{review}', [ReviewController::class, 'show'])->name('show');
    Route::patch('/{review}', [ReviewController::class, 'update'])->name('update');
});
