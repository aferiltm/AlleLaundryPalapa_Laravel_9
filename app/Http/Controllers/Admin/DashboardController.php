<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Function to show admin dashboard view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = Auth::user();

        $recentTransactions = Transaction::whereNull('finish_date')
            ->with('status')
            ->where('service_type_id', 1)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $membersCount = User::where('role', Role::Member)->count();

        $transactionsCount = Transaction::count();

        // Mendeteksi transaksi yang sedang berjalan
        $transactionsRunCount = Transaction::whereNull('finish_date')->count();


        // Menambahkan transaksi yang sudah selesai
        $completedTransactionsCount = Transaction::whereNotNull('finish_date')->count();

        $expressTransactions = Transaction::whereNull('finish_date')
            ->with('status')
            ->where('service_type_id', 2)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $kilatTransactions = Transaction::whereNull('finish_date')
            ->with('status')
            ->where('service_type_id', 3)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.index', compact(
            'user',
            'recentTransactions',
            'membersCount',
            'transactionsCount',
            'completedTransactionsCount',
            'expressTransactions',
            'kilatTransactions',
            'transactionsRunCount',
        ));
    }

    //Fungsi Menampilkan Chart Data Pendapatan/Revenue
    public function getRevenueData(Request $request)
    {
        $period = $request->input('period', 'monthly');

        if ($period === 'monthly') {
            $months = [
                1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni",
                7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
            ];

            $revenues = Transaction::select(DB::raw('SUM(total) as total'), DB::raw('MONTH(created_at) as month'))
                ->whereYear('created_at', date('Y'))
                ->whereNotNull('total')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month');

            $formattedData = collect(range(1, 12))->map(function ($month) use ($revenues, $months) {
                return [
                    'month' => $months[$month],
                    'total' => $revenues[$month]->total ?? 0
                ];
            });

        } else {
            // Ambil tahun awal & akhir dari request
            $startYear = (int) $request->input('start_year', date('Y') - 4);
            $endYear = (int) $request->input('end_year', date('Y'));

            // Pastikan startYear lebih kecil dari endYear
            if ($startYear > $endYear) {
                return response()->json(['error' => 'Rentang tahun tidak valid'], 400);
            }

            // Ambil data transaksi dari database
            $revenues = Transaction::select(DB::raw('SUM(total) as total'), DB::raw('YEAR(created_at) as year'))
                ->whereBetween(DB::raw('YEAR(created_at)'), [$startYear, $endYear])
                ->whereNotNull('total')
                ->groupBy('year')
                ->orderBy('year')
                ->get()
                ->keyBy('year');

            // Pastikan semua tahun dalam rentang tampil, isi 0 jika tidak ada transaksi
            $formattedData = collect(range($startYear, $endYear))->map(function ($year) use ($revenues) {
                return [
                    'year' => $year,
                    'total' => $revenues[$year]->total ?? 0 // Jika tidak ada data, isi dengan 0
                ];
            });
        }

        return response()->json($formattedData);
    }

    // Menampilkan Chart Data Transaksi
    public function getTransactionData(Request $request)
    {
        $period = $request->query('period', 'monthly');

        if ($period == 'monthly') {
            $months = [
                1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni",
                7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
            ];

            // Ambil data transaksi berdasarkan bulan dalam tahun berjalan
            $transactions = Transaction::selectRaw('MONTH(created_at) as month,
                    SUM(CASE WHEN service_type_id = 3 THEN 1 ELSE 0 END) as kilat,
                    SUM(CASE WHEN service_type_id = 2 THEN 1 ELSE 0 END) as express,
                    SUM(CASE WHEN service_type_id = 1 THEN 1 ELSE 0 END) as regular')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month');

            // Pastikan semua bulan dari Januari - Desember ada dalam hasil akhir
            $formattedData = collect(range(1, 12))->map(function ($month) use ($transactions, $months) {
                return [
                    'labels' => $months[$month],
                    'kilat' => $transactions[$month]->kilat ?? 0,
                    'express' => $transactions[$month]->express ?? 0,
                    'regular' => $transactions[$month]->regular ?? 0
                ];
            });

        } else {
            // Ambil tahun awal & akhir dari request
            $startYear = (int) $request->input('start_year', date('Y') - 4);
            $endYear = (int) $request->input('end_year', date('Y'));

            // Pastikan startYear lebih kecil dari endYear
            if ($startYear > $endYear) {
                return response()->json(['error' => 'Rentang tahun tidak valid'], 400);
            }

            // Ambil data transaksi berdasarkan tahun
            $transactions = Transaction::selectRaw('YEAR(created_at) as year,
                    SUM(CASE WHEN service_type_id = 3 THEN 1 ELSE 0 END) as kilat,
                    SUM(CASE WHEN service_type_id = 2 THEN 1 ELSE 0 END) as express,
                    SUM(CASE WHEN service_type_id = 1 THEN 1 ELSE 0 END) as regular')
                ->whereBetween(DB::raw('YEAR(created_at)'), [$startYear, $endYear])
                ->groupBy('year')
                ->orderBy('year')
                ->get()
                ->keyBy('year');

            // Pastikan semua tahun dari rentang ada dalam hasil akhir
            $formattedData = collect(range($startYear, $endYear))->map(function ($year) use ($transactions) {
                return [
                    'labels' => (string) $year,
                    'kilat' => $transactions[$year]->kilat ?? 0,
                    'express' => $transactions[$year]->express ?? 0,
                    'regular' => $transactions[$year]->regular ?? 0
                ];
            });
        }

        return response()->json([
            'labels' => $formattedData->pluck('labels'),
            'kilat' => $formattedData->pluck('kilat'),
            'express' => $formattedData->pluck('express'),
            'regular' => $formattedData->pluck('regular')
        ]);
    }

}
