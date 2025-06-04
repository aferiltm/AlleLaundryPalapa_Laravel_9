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
use App\Http\Controllers\Admin\Transaction\TransactionController;
use App\Http\Controllers\Admin\Transaction\PrintTransactionController;
use App\Http\Controllers\Admin\Transaction\TransactionSessionController;

Route::get('/', [DashboardController::class, 'index'])->name('index');

// Rute untuk kategori satuan
// Route::group(['prefix' => 'admin/transactions', 'as' => 'admin.transactions.'], function () {
//     Route::get('/', [TransactionController::class, 'index'])->name('index'); // Menampilkan daftar transaksi
//     Route::get('/create', [TransactionController::class, 'create'])->name('create'); // Menampilkan form input transaksi
//     Route::post('/store', [TransactionController::class, 'store'])->name('store'); // Menyimpan transaksi ke database
//     Route::get('/print/{transaction}', [PrintTransactionController::class, 'index'])->name('print.index'); // Mencetak transaksi
// });

// Rute untuk sesi transaksi
Route::group(['prefix' => 'admin/transactions/session', 'as' => 'admin.transactions.session.'], function () {
    Route::post('/store', [TransactionSessionController::class, 'store'])->name('store'); // Menyimpan transaksi ke sesi
    Route::delete('/destroy/{rowId}', [TransactionSessionController::class, 'destroy'])->name('destroy'); // Menghapus transaksi dari sesi
});

// // Rute untuk kategori satuan price list
// Route::group(['prefix' => 'admin/price-lists', 'as' => 'admin.price-lists.'], function () {
//     Route::get('/', [PriceListController::class, 'index'])->name('index'); // Menampilkan daftar price list
//     Route::post('/', [PriceListController::class, 'store'])->name('store'); // Menyimpan price list
//     Route::get('/{priceList}', [PriceListController::class, 'show'])->name('show'); // Menampilkan detail price list
//     Route::patch('/{priceList}', [PriceListController::class, 'update'])->name('update'); // Mengupdate price list
// });

// // Rute untuk kategori kiloan price list
// Route::group(['prefix' => 'admin/price-lists-kiloan', 'as' => 'admin.price-lists-kiloan.'], function () {
//     Route::get('/', [PriceListKiloanController::class, 'index'])->name('index'); // Menampilkan daftar price list kiloan
//     Route::post('/', [PriceListKiloanController::class, 'store'])->name('store'); // Menyimpan price list kiloan
//     Route::get('/{priceListKiloan}', [PriceListKiloanController::class, 'show'])->name('show'); // Menampilkan detail price list kiloan
//     Route::patch('/{priceListKiloan}', [PriceListKiloanController::class, 'update'])->name('update'); // Mengupdate price list kiloan
// });

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
});

// Route::group([
//     'prefix' => 'price-lists',
//     'as' => 'price-lists.',
// ], function () {
//     Route::get('/', [PriceListController::class, 'index'])->name('index');
//     Route::post('/', [PriceListController::class, 'store'])->name('store');
//     Route::get('/{priceList}', [PriceListController::class, 'show'])->name('show');
//     Route::patch('/{priceList}', [PriceListController::class, 'update'])->name('update');
// });

// Route::prefix('price-lists')->name('price-lists.')->group(function () {
//     // Untuk Satuan
//     Route::get('/', [PriceListController::class, 'index'])->name('index');
//     Route::post('/', [PriceListController::class, 'store'])->name('store');
//     Route::get('/{priceList}', [PriceListController::class, 'show'])->name('show');
//     Route::patch('/{priceList}', [PriceListController::class, 'update'])->name('update');

//     // Untuk Kiloan (gunakan subprefix 'kiloan')
//     Route::prefix('kiloan')->name('kiloan.')->group(function () {
//         Route::post('/', [PriceListKiloanController::class, 'store'])->name('store');
//         Route::patch('/{priceListKiloan}', [PriceListKiloanController::class, 'update'])->name('update');
//         Route::get('/{priceListKiloan}', [PriceListKiloanController::class, 'show'])->name('show');
//     });
// });

// Untuk satuan
// Route::resource('admin/price-lists', \App\Http\Controllers\Admin\PriceListController::class)
//     ->only(['index', 'store', 'update', 'show'])
//     ->names('admin.price-lists');
// Untuk kiloan
// Route::post('/admin/price-lists-kiloan', [\App\Http\Controllers\Admin\PriceListKiloanController::class, 'store'])
//     ->name('admin.price-lists-kiloan.store');
// Route::patch('/admin/price-lists-kiloan/{priceListKiloan}', [\App\Http\Controllers\Admin\PriceListKiloanController::class, 'update'])
//     ->name('admin.price-lists-kiloan.update');
// Route::get('/admin/price-lists-kiloan/{priceListKiloan}', [\App\Http\Controllers\Admin\PriceListKiloanController::class, 'show'])
//     ->name('admin.price-lists-kiloan.show');


Route::post('/items', [ItemController::class, 'store'])->name('items.store');

Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');

Route::group([
    'prefix' => 'vouchers',
    'as' => 'vouchers.',
], function () {
    Route::get('/', [VoucherController::class, 'index'])->name('index');
    Route::post('/', [VoucherController::class, 'store'])->name('store');
    Route::patch('/{voucher}', [VoucherController::class, 'update'])->name('update');
    Route::delete('/{voucher}', [VoucherController::class, 'destroy'])->name('destroy');
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

// Route::get('/laporanview', 'laporanview');

Route::group([
    'prefix' => 'service-types',
    'as' => 'service-types.',
], function () {
    Route::get('/{serviceType}', [ServiceTypeController::class, 'show'])->name('show');
    Route::patch('/{serviceType}', [ServiceTypeController::class, 'update'])->name('update');
});
