<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryKiloan;
use App\Models\Item;
use App\Models\PriceList;
use App\Models\PriceListKiloan;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailKiloan;
use App\Models\User;
use App\Models\UserVoucher;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Enums\Role;

class TransactionController extends Controller
{
    /**
     * Display all transaction histories
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $currentMonth = $request->input('month', date('m'));
        $currentYear = $request->input('year', date('Y'));

        $user = Auth::user();

        $ongoingTransactions = Transaction::with('member')->whereYear('created_at', '=', $currentYear)
            ->whereMonth('created_at', '=', $currentMonth)
            ->where('service_type_id', 1)
            ->where('finish_date', null)
            ->orderBy('created_at', 'DESC')
            ->get();

        $ongoingExpressTransactions = Transaction::with('member')->whereYear('created_at', '=', $currentYear)
            ->whereMonth('created_at', '=', $currentMonth)
            ->where('service_type_id', 2)
            ->where('finish_date', null)
            ->orderBy('created_at', 'DESC')
            ->get();

        $ongoingKilatTransactions = Transaction::with('member')->whereYear('created_at', '=', $currentYear)
            ->whereMonth('created_at', '=', $currentMonth)
            ->where('service_type_id', 3)
            ->where('finish_date', null)
            ->orderBy('created_at', 'DESC')
            ->get();

        $finishedTransactions = Transaction::with('member')->whereYear('created_at', '=', $currentYear)
            ->whereMonth('created_at', '=', $currentMonth)
            ->where('finish_date', '!=', null)
            ->orderBy('created_at', 'DESC')
            ->get();

        $status = Status::all();
        $years = Transaction::selectRaw('YEAR(created_at) as Tahun')->distinct()->get();

        return view('admin.transactions_history', compact(
            'user',
            'status',
            'years',
            'currentYear',
            'currentMonth',
            'ongoingTransactions',
            'ongoingExpressTransactions',
            'ongoingKilatTransactions',
            'finishedTransactions'
        ));
    }

    /**
     * Function to show admin input transaction view
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request): View
    {
        $user = Auth::user();
        $items = Item::all();
        $categories = Category::all();
        $services = Service::all();
        $serviceTypes = ServiceType::all();
        $categories_kiloan = CategoryKiloan::all();

        // Initialize phone_number and member_name
        // $phone_number = '';
        $phone_number ='';
        $member_name = '';

        // Check if there is an active transaction in session
        if ($request->session()->has('transaction') && $request->session()->has('memberIdTransaction')) {
            $sessionTransaction = $request->session()->get('transaction');

            $memberIdSessionTransaction = $request->session()->get('memberIdTransaction');

            if (!$request->session()->has('phone_number') && isset($sessionTransaction[0]['phone_number'])) {
                $request->session()->put('phone_number', $sessionTransaction[0]['phone_number']);
            }

            if (!$request->session()->has('member_name') && isset($sessionTransaction[key($sessionTransaction)]['member_name'])) {
                $request->session()->put('member_name', $sessionTransaction[key($sessionTransaction)]['member_name']);
            }

            // Get user's voucher
            $vouchers = UserVoucher::where([
                'user_id' => $memberIdSessionTransaction,
                'used'    => 0,
            ])->get();

            // Sum total price
            $totalPrice = 0;
            foreach ($sessionTransaction as &$trs) {
                if (isset($trs['subTotal'])) {
                    $totalPrice += $trs['subTotal'];
                }
                if (isset($trs['subTotalKiloan'])) {
                    $totalPrice += $trs['subTotalKiloan'];
                }
            }

            $phone_number = $request->session()->get('phone_number', '');
            $member_name = $request->session()->get('member_name', '');

            return view('admin.transaction_input', compact(
                'user',
                'items',
                'categories',
                'services',
                'serviceTypes',
                'categories_kiloan',
                'sessionTransaction',
                'memberIdSessionTransaction',
                'totalPrice',
                'vouchers',
                'phone_number',
                'member_name',
            ));
        }

        return view('admin.transaction_input', compact(
            'user',
            'items',
            'categories',
            'services',
            'serviceTypes',
            'categories_kiloan',
        ));
    }

    /**
     * Store transaction to database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'payment-amount' => ['required', 'integer'],
            'service-type' => ['required', 'integer'],
        ]);

        DB::beginTransaction();

        $memberId = $request->session()->get('memberIdTransaction');
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $adminId = $user->id;
        $sessionTransaction = $request->session()->get('transaction');

        // Hitung total harga
        $totalPrice = 0;
        foreach ($sessionTransaction as &$trs) {
            if (isset($trs['subTotal'])) {
                $totalPrice += $trs['subTotal'];
            }
            if (isset($trs['subTotalKiloan'])) {
                $totalPrice += $trs['subTotalKiloan'];
            }
        }
        $discount = 0;

        //Cek apakah ada voucher yang digunakan
        if ($request->input('voucher') != 0) {
            // Ambil banyak potongan dari database

            $userVoucher = UserVoucher::where('id', $request->input('voucher'))->firstOrFail();
            if (!$userVoucher->voucher) {
                abort(404);
            }

            $discount = $userVoucher->voucher->discount_value;

            // Kurangi harga dengan potongan
            $totalPrice -= $discount;
            if ($totalPrice < 0) {
                $totalPrice = 0;
            }

            // Ganti status used pada tabel users_vouchers
            $userVoucher->used = 1;
            $userVoucher->save();
        }

        // Retrieve the service type ID from the request
        $serviceTypeId = $request->input('service-type');
        // Hitung estimasi selesai
        switch ($serviceTypeId) {
            case 1: // Reguler
                $estimatedFinish = now()->addDays(3);
                break;
            case 2: // Priority
                $estimatedFinish = now()->addDays(2);
                break;
            case 3: // Express
                $estimatedFinish = now()->addDays(1);
                break;
            default:
                $estimatedFinish = now(); // fallback
        }

        // Cek apakah menggunakan service type non reguler
        $cost = 0;
        if ($serviceTypeId != 0) {
            $serviceTypeCost = ServiceType::where('id', $serviceTypeId)->firstOrFail();
            $cost = $serviceTypeCost->cost;
            // Tambahkan harga dengan cost
            $totalPrice += $cost;
        }

        // Check if payment < total
        if ($request->input('payment-amount') < $totalPrice) {
            return redirect()->route('admin.transactions.create')
                ->with('error', 'Pembayaran kurang');
        }

         // Generate transaction code
        $transactionCode = $this->generateTransactionCode($serviceTypeId);

        $transaction = new Transaction([
            'transaction_code' => $transactionCode,
            'status_id'       => 1,
            'member_id'       => $memberId,
            'admin_id'        => $adminId,
            'finish_date'     => null,
            'estimated_finish_at' => $estimatedFinish,
            'discount'        => $discount,
            'total'           => $totalPrice,
            // 'service_type_id' => $request->input('service-type'),
            'service_type_id' => $serviceTypeId,
            'service_cost'    => $cost,
            'payment_amount'  => $request->input('payment-amount'),
        ]);
        $transaction->save();

        foreach ($sessionTransaction as &$trs) {
            if (isset($trs['subTotal'])) {
                $price = PriceList::where([
                    'item_id'     => $trs['itemId'],
                    'category_id' => $trs['categoryId'],
                    'service_id'  => $trs['serviceId'],
                ])->firstOrFail();

                $transaction_detail = new TransactionDetail([
                    'transaction_id' => $transaction->id,
                    'price_list_id'  => $price->id,
                    'quantity'       => $trs['quantity'],
                    'price'          => $price->price,
                    'sub_total'      => $trs['subTotal'],
                ]);
                $transaction_detail->save();
            }

            if (isset($trs['subTotalKiloan'])) {
                $priceKiloan = PriceListKiloan::where([
                    'category_kiloan_id' => $trs['categoryKiloanId'],
                ])->firstOrFail();

                $transaction_details_kiloan = new TransactionDetailKiloan([
                    'transaction_id' => $transaction->id,
                    'price_list_kiloan_id'  => $priceKiloan->id,
                    'quantity' => $trs['heavy'] ?? 0,
                    'price'          => $priceKiloan->price,
                    'sub_total'      => $trs['subTotalKiloan'],
                ]);
                $transaction_details_kiloan->save();
            }
        }

        $user = User::where('id', $memberId)->firstOrFail();
        // $user->point = $user->point + 1;
        if ($totalPrice > 100000) {
            $user->point += 7;
        } elseif ($totalPrice > 50000) {
            $user->point += 5;
        } else {
            $user->point += 2;
        }

        $user->save();

        $request->session()->forget('transaction');
        $memberId = $request->session()->get('memberIdTransaction');
        $request->session()->forget('phone_number');
        $request->session()->forget('member_name');

        DB::commit();

        return redirect()->route('admin.transactions.create')
            ->with('success', 'Transaksi berhasil disimpan dengan kode: ' . $transactionCode)
            ->with('id_trs', $transaction->id);
    }

    private function generateTransactionCode($serviceTypeId)
    {
        // Tentukan prefix berdasarkan serviceTypeId
        if ($serviceTypeId == 1) {
            $prefix = 'TR'; // Reguler
        } elseif ($serviceTypeId == 2) {
            $prefix = 'TE'; // Express
        } elseif ($serviceTypeId == 3) {
            $prefix = 'TK'; // Kilat
        } else {
            throw new \Exception("Service Type tidak dikenali.");
        }

        // Ambil transaksi terakhir berdasarkan prefix
        $lastTransaction = Transaction::where('transaction_code', 'like', $prefix . '%')
            ->orderBy('created_at', 'desc')
            ->first();

        // Ambil angka terakhir, default ke 0 jika tidak ada
        $lastNumber = $lastTransaction ? (int)substr($lastTransaction->transaction_code, 2) : 0;

        // Tambahkan 1 dan format ke 5 digit
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        // Gabungkan prefix dan nomor baru
        return $prefix . $newNumber;
    }


    /**
     * Return transaction data by id
     *
     * @param  \App\Models\Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($id)
    {
        $transaction = Transaction::with([
            // Untuk transaksi satuan
            'transaction_details',
            'transaction_details.price_list',
            'transaction_details.price_list.item',
            'transaction_details.price_list.service',
            'transaction_details.price_list.category',

            // Untuk transaksi kiloan
            'transaction_details_kiloan',
            'transaction_details_kiloan.price_list_kiloan',
            'transaction_details_kiloan.price_list_kiloan.category_kiloan',

            'service_type',
            'member'
        ])->findOrFail($id);

        return response()->json([
            'transaction_code' => $transaction->transaction_code,
            'payment_amount' => $transaction->payment_amount,
            'total' => $transaction->total,
            'service_type' => $transaction->service_type,
            'transaction_details' => $transaction->transaction_details,
            'transaction_details_kiloan' => $transaction->transaction_details_kiloan,
        ]);
    }

    /**
     * Change transaction status
     *
     * @param  \App\Models\Transaction $transaction
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Transaction $transaction, Request $request): JsonResponse
    {
        $currentDate = null;
        // Jika status 3 maka artinya sudah selesai, set tgl menjadi tgl selesai
        if ($request->input('val') == 3) {
            $currentDate = date('Y-m-d H:i:s');
        }

        $transaction->status_id = $request->input('val', 2);
        $transaction->finish_date = $currentDate;
        $transaction->save();

        return response()->json();
    }

    // public function updateStatus(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:transactions,id',
    //         'status_id' => 'required|integer',
    //     ]);

    //     $transaction = Transaction::with('member')->findOrFail($request->id); // pastikan relasi member di-load
    //     $transaction->status_id = $request->status_id;
    //     $transaction->save();

    //     if ($transaction->status_id == 3) {
    //         try {
    //             $this->sendWhatsAppMessage($transaction);
    //         } catch (\Exception $e) {
    //             Log::error('WA Error: ' . $e->getMessage());
    //             return response()->json(['message' => 'Gagal mengirim WA'], 500);
    //         }
    //     }

    //     return response()->json(['message' => 'Status berhasil diperbarui.'], 200);
    // }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'        => 'required|exists:transactions,id',
            'status_id' => 'required|integer',
        ]);

        $transaction = Transaction::with('member')->findOrFail($request->id);

        // definisi transisi yang diizinkan (urutan wajib)
        $allowedTransitions = [
            1 => 2,   // Belum dikerjakan → Sedang dikerjakan
            2 => 3,   // Sedang dikerjakan → Selesai
        ];

        $currentStatus = $transaction->status_id;
        $newStatus     = $request->status_id;

        // tolak jika tidak sesuai urutan
        if (!isset($allowedTransitions[$currentStatus]) || $allowedTransitions[$currentStatus] != $newStatus) {
            return response()->json(['message' => 'Perubahan status tidak valid / tidak berurutan.'], 422);
        }

        // update
        $transaction->status_id   = $newStatus;
        if ($newStatus == 3) {               // selesai → simpan finish_date
            $transaction->finish_date = now();
        }
        $transaction->save();

        // kirim WA jika selesai
        if ($newStatus == 3) {
            try {
                $this->sendWhatsAppMessage($transaction);
            } catch (\Exception $e) {
                Log::error('WA Error: ' . $e->getMessage());
                return response()->json(['message' => 'Gagal mengirim WA'], 500);
            }
        }

        return response()->json(['message' => 'Status berhasil diperbarui.'], 200);
    }

    protected function sendWhatsAppMessage($transaction)
    {
        $member = $transaction->member;

        if (!$member || $member->role !== Role::Member) {
            Log::info("WA not sent: member tidak valid atau bukan role 2", [
                'member_id' => $member?->id,
                'role' => $member?->role
            ]);
            return;
        }

        $original = $member->phone_number;
        $phone = preg_replace('/[^0-9]/', '', $original); // Hapus semua karakter non-digit

        if (strpos($phone, '08') === 0) {
            $phone = '62' . substr($phone, 1);
        } elseif (strpos($phone, '620') === 0) {
            $phone = '62' . substr($phone, 3);
        }

        Log::info("Mengirim WA ke: " . $phone); // Tambahkan ini untuk memastikan nomor sudah benar

        $name = $member->name;
        $code = $transaction->transaction_code;

        $message = "Halo $name, \n Pesanan laundry Anda dengan kode *$code* telah *SELESAI*!. Silakan datang ke Alle Laundry Palapa untuk mengambilnya. \n Jam Operasional: \n - Senin - Jumat (07:00 - 19:00 WIB) \n Sabtu - Minggu (08:00 - 16:00 WIB) \n Alamat Laundry: Jl. Palapa Raya, RT.4/RW.1, Kedoya Sel., Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11520 \n Terima kasih telah menggunakan layanan kami!";

        try {
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_API_KEY'), // Dari .env
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
            ]);

            if (!$response->successful()) {
                Log::error('Fonnte gagal: ' . $response->body());
                throw new \Exception('Fonnte error');
            }
        } catch (\Exception $e) {
            Log::error('Exception kirim WA: ' . $e->getMessage());
            throw $e;
        }
    }
}
