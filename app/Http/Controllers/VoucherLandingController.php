<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class VoucherLandingController extends Controller
{
    /**
     * Show voucher page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $vouchers = Voucher::all();

        return view('landing', compact( 'vouchers'));
    }

    /**
     * Add new voucher to database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
}
