<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ComplaintSuggestion;
use App\Models\UserVoucher;
use App\Models\Category;
use App\Models\Item;
use App\Models\PriceList;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Status;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailKiloan;
use App\Models\User;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Show report page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = Auth::user();
        $years = Transaction::selectRaw('YEAR(created_at) as Tahun')->distinct()->get();
        // $months = Transaction::selectRaw('MONTH(created_at) as Bulan')->distinct()->get();

        return view('admin.report', compact('user', 'years'));
    }

    /**
     * Print report as pdf
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request): Response
    {
        $monthInput = $request->input('month');
        $yearInput = $request->input('year');
        $dateObj = DateTime::createFromFormat('!m', $monthInput);

        if ($dateObj) {
            $month = $dateObj->format('F');
        } else {
            abort(500);
        }

        $revenue = Transaction::whereMonth('created_at', $monthInput)
            ->whereYear('created_at', $yearInput)->sum('total');
        $transactionsCount = Transaction::whereMonth('created_at', $monthInput)
            ->whereYear('created_at', $yearInput)->count();
        $pdf = PDF::loadview(
            'admin.report_pdf',
            compact(
                'monthInput',
                'yearInput',
                'revenue',
                'transactionsCount',
            )
        );

        return $pdf->stream();
    }

    /**
     * Get month by year report
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMonth(Request $request): JsonResponse
    {
        $year = $request->input('year', now()->year);
        $month = Transaction::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as Bulan')
            ->distinct()
            ->get();

        return response()->json($month);
    }

    /**
     * Summary of printAnalysis
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

     public function printAnalysis(Request $request): Response
     {
        $bulanAwal = $request->input('bulan_awal');
        $bulanAkhir = $request->input('bulan_akhir');
        $tahun = $request->input('year');

        // Validasi input
        if (!$bulanAwal || !$bulanAkhir || !$tahun) {
            abort(400, 'Data tidak lengkap');
        }

        // Ambil data rating dari ComplaintSuggestion
        $ratings = ComplaintSuggestion::whereYear('created_at', $tahun)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Siapkan data rating dari 1 sampai 5
        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $data[$i] = $ratings[$i] ?? 0;
        }

        // Nama bulan awal & akhir
        $namaBulanAwal = Carbon::create()->month($bulanAwal)->translatedFormat('F');
        $namaBulanAkhir = Carbon::create()->month($bulanAkhir)->translatedFormat('F');

        // Tambahkan setelah $namaBulanAkhir
        $chartUrlRatings = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'pie',
            'options' => [
                'aspectRatio' => 1, // <<< Tambahkan ini supaya proporsional
                'plugins' => [
                    'legend' => ['position' => 'top'],
                ],
            ],
            'data' => [
                'labels' => ['Rating 1', 'Rating 2', 'Rating 3', 'Rating 4', 'Rating 5'],
                'datasets' => [[
                    'data' => array_values($data),
                    'backgroundColor' => [
                        'rgba(255, 0, 0, 0.82)',
                        'rgba(255, 101, 0, 0.82)',
                        'rgba(220, 230, 0, 0.82)',
                        'rgba(27, 255, 0, 0.82)',
                        'rgba(0, 118, 219, 0.82)'
                    ],
                    'borderColor' => [
                        'rgba(154, 0, 0, 0.8)',
                        'rgba(162, 64, 0, 0.82)',
                        'rgba(181, 189, 0, 0.82)',
                        'rgba(17, 161, 0, 0.82)',
                        'rgba(0, 92, 169, 0.82)'
                    ],
                    'borderWidth' => 1
                ]]
            ]
        ]));


        // TRANSACTION==================================
        // Ambil data transaksi Reguler dan Priority
        $regularTransactions = Transaction::where('service_type_id', 1)
            ->whereYear('created_at', $tahun)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
            ->count();

        $priorityTransactions = Transaction::where('service_type_id', 2)
            ->whereYear('created_at', $tahun)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
            ->count();

        // Siapkan data untuk chart
        $transactionData = [
            'Regular' => $regularTransactions,
            'Priority' => $priorityTransactions,
        ];
        // Pie Chart
        $transactionChartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'pie',
            'data' => [
                'labels' => array_keys($transactionData),
                'datasets' => [[
                    'data' => array_values($transactionData),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    'borderWidth' => 1
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['position' => 'top'],
                ],
            ],
        ]));
        // Ambil data transaksi Reguler dan Priority per bulan
        $monthlyData = Transaction::select(DB::raw('MONTH(created_at) as month'), DB::raw('service_type_id, COUNT(*) as count'))
            ->whereYear('created_at', $tahun)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
            ->groupBy('month', 'service_type_id')
            ->get();
        // Prepare data for line chart
        $lineChartData = [
            'Regular' => array_fill($bulanAwal, $bulanAkhir - $bulanAwal + 1, 0),
            'Priority' => array_fill($bulanAwal, $bulanAkhir - $bulanAwal + 1, 0),
        ];
        foreach ($monthlyData as $transaction) {
            $month = $transaction->month;
            if ($transaction->service_type_id == 1) {
                $lineChartData['Regular'][$month] = $transaction->count;
            } elseif ($transaction->service_type_id == 2) {
                $lineChartData['Priority'][$month] = $transaction->count;
            }
        }
        // Prepare month names for labels
        $monthNames = [];
        for ($i = $bulanAwal; $i <= $bulanAkhir; $i++) {
            $monthNames[] = Carbon::create()->month($i)->translatedFormat('F'); // Get month name
        }
        // Generate line chart URL
        $transactionLineChartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'line',
            'data' => [
                'labels' => $monthNames,
                'datasets' => [
                    [
                        'label' => 'Jumlah Transaksi Reguler',
                        'data' => array_values($lineChartData['Regular']),
                        'fill' => false,
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'tension' => 0.1
                    ],
                    [
                        'label' => 'Jumlah Transaksi Priority',
                        'data' => array_values($lineChartData['Priority']),
                        'fill' => false,
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'tension' => 0.1
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ]));


        // Laporan Komplain
        $complaintData = ComplaintSuggestion::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $tahun)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
            ->where('type', 2)
            ->groupBy('month')
            ->get();
        // Prepare data for complaint line chart
        $complaintLineChartData = array_fill($bulanAwal, $bulanAkhir - $bulanAwal + 1, 0);
        foreach ($complaintData as $complaint) {
            $month = $complaint->month;
            $complaintLineChartData[$month] = $complaint->count;
        }
        // Generate line chart URL for complaints
        $complaintLineChartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'line',
            'data' => [
                'labels' => $monthNames,
                'datasets' => [
                    [
                        'label' => 'Jumlah Komplain',
                        'data' => array_values($complaintLineChartData),
                        'fill' => false,
                        'borderColor' => 'rgba(255, 206, 86, 1)',
                        'tension' => 0.1
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ]));


        // Fetch voucher usage data
        $voucherData = UserVoucher::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $tahun)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
            ->groupBy('month')
            ->get();
        // Prepare data for voucher line chart
        $voucherLineChartData = array_fill($bulanAwal, $bulanAkhir - $bulanAwal + 1, 0);
        foreach ($voucherData as $voucher) {
            $month = $voucher->month;
            $voucherLineChartData[$month] = $voucher->count;
        }
        // Generate line chart URL for vouchers
        $voucherLineChartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'line',
            'data' => [
                'labels' => $monthNames,
                'datasets' => [
                    [
                        'label' => 'Jumlah Voucher Digunakan',
                        'data' => array_values($voucherLineChartData),
                        'fill' => false,
                        'borderColor' => 'rgba(153, 102, 255, 1)',
                        'tension' => 0.1
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ]));

        // Fetch monthly revenue data
        $monthlyRevenue = Transaction::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as revenue'))
            ->whereYear('created_at', $tahun)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
            ->groupBy('month')
            ->get();
        // Prepare revenue data for table and line chart
        $revenueData = array_fill($bulanAwal, $bulanAkhir - $bulanAwal + 1, 0);
        foreach ($monthlyRevenue as $revenue) {
            $month = $revenue->month;
            $revenueData[$month] = $revenue->revenue;
        }
        // Generate line chart URL for revenue
        $revenueLineChartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'line',
            'data' => [
                'labels' => $monthNames,
                'datasets' => [
                    [
                        'label' => 'Pendapatan',
                        'data' => array_values($revenueData),
                        'fill' => false,
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'tension' => 0.1
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ]));


        // Laporan Pesanan Kiloan dan Satuan
        // Ambil data pesanan Kiloan
        $kiloanData = TransactionDetailKiloan::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
        ->whereYear('created_at', $tahun)
        ->whereBetween(DB::raw('MONTH(created_at)'), [$bulanAwal, $bulanAkhir])
        ->groupBy('month')
        ->get();

        // Ambil data pesanan Satuan
        $satuanData = TransactionDetail::select(DB::raw('MONTH(transaction_details.created_at) as month'), DB::raw('COUNT(*) as count'))
        ->join('price_lists', 'transaction_details.price_list_id', '=', 'price_lists.id')
        ->whereYear('transaction_details.created_at', $tahun)
        ->whereBetween(DB::raw('MONTH(transaction_details.created_at)'), [$bulanAwal, $bulanAkhir])
        ->groupBy('month')
        ->get();

        // Total jumlah
        $kiloanTotal = $kiloanData->sum('count');
        $satuanTotal = $satuanData->sum('count');

        // Data Pie Chart
        $pieChartData = [
        'Kiloan' => $kiloanTotal,
        'Satuan' => $satuanTotal,
        ];

        // Data Line Chart
        $lineChartData = [
        'Kiloan' => array_fill($bulanAwal, $bulanAkhir - $bulanAwal + 1, 0),
        'Satuan' => array_fill($bulanAwal, $bulanAkhir - $bulanAwal + 1, 0),
        ];

        // Isi data line chart
        foreach ($kiloanData as $kiloan) {
        $month = $kiloan->month;
        $lineChartData['Kiloan'][$month] = $kiloan->count;
        }
        foreach ($satuanData as $satuan) {
        $month = $satuan->month;
        $lineChartData['Satuan'][$month] = $satuan->count;
        }

        // Nama bulan
        $monthNames = [];
        for ($i = $bulanAwal; $i <= $bulanAkhir; $i++) {
        $monthNames[] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
        }

        // Buat Pie Chart URL
        $pieChartUrlKL = "https://quickchart.io/chart?c=" . urlencode(json_encode([
        'type' => 'pie',
        'data' => [
            'labels' => array_keys($pieChartData),
            'datasets' => [[
                'data' => array_values($pieChartData),
                'backgroundColor' => [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                ],
                'borderColor' => [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                'borderWidth' => 1
            ]]
        ],
        'options' => [
            'plugins' => [
                'legend' => ['position' => 'top'],
            ],
        ],
        ]));

        // Buat Line Chart URL
        $lineChartUrlKL = "https://quickchart.io/chart?c=" . urlencode(json_encode([
        'type' => 'line',
        'data' => [
            'labels' => $monthNames,
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan Kiloan',
                    'data' => array_values($lineChartData['Kiloan']),
                    'fill' => false,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'tension' => 0.1
                ],
                [
                    'label' => 'Jumlah Pesanan Satuan',
                    'data' => array_values($lineChartData['Satuan']),
                    'fill' => false,
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'tension' => 0.1
                ]
            ]
        ],
        'options' => [
            'scales' => [
                'y' => [
                    'beginAtZero' => true
                ]
            ]
        ]
        ]));
        $kiloanCount = $kiloanTotal;
        $satuanCount = $satuanTotal;

        // Kirim ke PDF
        $pdf = PDF::loadview('admin.report_analysis_pdf', compact(
            'data', 'tahun', 'bulanAwal', 'bulanAkhir', 'namaBulanAwal', 'namaBulanAkhir',
            'chartUrlRatings',
            'transactionData','transactionChartUrl','transactionLineChartUrl',
            'complaintLineChartUrl','complaintLineChartData',
            'voucherLineChartUrl',
            'revenueData','revenueLineChartUrl',
            'pieChartUrlKL', 'lineChartUrlKL', 'kiloanCount', 'satuanCount',
        ));
        return $pdf->stream();
    }

}
