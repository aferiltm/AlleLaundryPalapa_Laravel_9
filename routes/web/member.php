<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\PointController;
use App\Http\Controllers\Member\VoucherController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\PriceListController;
use App\Http\Controllers\Member\TransactionController;
use App\Http\Controllers\Member\ComplaintSuggestionController;
use App\Http\Controllers\Member\ReviewController;

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::get('/price-lists', [PriceListController::class, 'index'])->name('price_lists.index');
Route::get('/points', [PointController::class, 'index'])->name('points.index');
Route::get('/vouchers/redeem/{voucher}', [VoucherController::class, 'store'])->name('vouchers.store');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/complaint-suggestions', [ComplaintSuggestionController::class, 'index'])->name('complaints.index');
Route::post('/complaint-suggestions', [ComplaintSuggestionController::class, 'store'])->name('complaints.store');
Route::get('/reviews', [ReviewController::class, 'index'])->name('review.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');
Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('review.show');
Route::get('/completed-transactions', [ComplaintSuggestionController::class, 'showCompletedTransactions'])->name('member.transactions.completed');

