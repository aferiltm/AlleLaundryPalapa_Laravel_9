<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ProfilePasswordController;
use App\Http\Controllers\Profile\ProfilePhotoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\VoucherLandingController;


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

// Home route
// Route::get('/', function () {
//     return view('landing');
// })->middleware('language');

// Route::get('/', [VoucherLandingController::class, 'index'])->middleware('language');

Route::get('/', [VoucherLandingController::class, 'index'])->middleware('language');

// Auth routes
Route::group(['middleware' => 'language'], function () {
    Route::get('login', [LoginController::class, 'show'])->name('login.show')->middleware('islogin');
    Route::post('login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('logout', [LoginController::class, 'logout'])->name('login.logout');

    Route::get('register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('register', [RegisterController::class, 'register'])->name('register.register');
    Route::get('register-admin', [RegisterController::class, 'registerAdminView'])->name('register.admin');
    Route::post('register-admin', [RegisterController::class, 'registerAdmin'])->name('register.register_admin');
});

// User profile routes
Route::group([
    'prefix' => 'profile',
    'middleware' => ['language', 'islogin'],
], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/photo/delete', [ProfilePhotoController::class, 'destroy'])->name('profile.photo.destroy');
    Route::patch('/password', [ProfilePasswordController::class, 'update'])->name('profile.password.update');
});

// Set language route
Route::get('/{locale}', LocaleController::class);


Route::get('/admin/members/search', function (Request $request) {
    $user = User::where('phone_number', $request->phone_number)->first();

    if ($user) {
        return response()->json([
            'success' => true,
            'name' => $user->name,
            'id' => $user->id
        ]);
    } else {
        return response()->json([
            'success' => false
        ]);
    }
})->name('admin.members.search');

Route::get('/admin/revenue-data', [DashboardController::class, 'getRevenueData'])->name('admin.revenue.data');
Route::get('/admin/transaksi-data', [DashboardController::class, 'getTransactionData'])->name('admin.transaksi.data');
Route::get('/admin/reports/get-month', [ReportController::class, 'getMonth'])->name('admin.reports.getMonth');
// Route::post('/admin/reports/print-analysis', [ReportController::class, 'printAnalysis'])->name('admin.reports.printAnalysis');
// Route::post('admin/reports/printAnalysis', [ReportController::class, 'printAnalysis'])->name('admin.reports.printAnalysis');
// routes/web.php
Route::post('/admin/reports/print-komplain', [ReportController::class, 'printKomplain'])->name('admin.reports.printKomplain');


use App\Http\Controllers\Admin\PriceListController;
use App\Http\Controllers\Admin\PriceListKiloanController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('price-lists')->name('price-lists.')->group(function () {
        // Untuk Satuan
        Route::get('/', [PriceListController::class, 'index'])->name('index');
        Route::post('/', [PriceListController::class, 'store'])->name('store');
        Route::get('/{priceList}', [PriceListController::class, 'show'])->name('show');
        Route::patch('/{priceList}', [PriceListController::class, 'update'])->name('update');
        Route::delete('/{priceList}', [PriceListController::class, 'destroy'])->name('destroy');

        // Untuk Kiloan
        Route::prefix('kiloan')->name('kiloan.')->group(function () {
            Route::post('/', [PriceListKiloanController::class, 'store'])->name('store');
            Route::patch('/{priceListKiloan}', [PriceListKiloanController::class, 'update'])->name('update');
            Route::get('/{priceListKiloan}', [PriceListKiloanController::class, 'show'])->name('show');
            Route::delete('/{priceListKiloan}', [PriceListKiloanController::class, 'destroyk'])->name('destroy');
        });
    });
});


