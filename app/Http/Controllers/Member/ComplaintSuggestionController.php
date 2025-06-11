<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ComplaintSuggestion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class ComplaintSuggestionController extends Controller
{
    /**
     * method to show complaint suggestion view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $transactions = Transaction::with('status')->where('member_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->orderBy('status_id', 'ASC')
            ->get();

        $transactions = Transaction::with(['service_type', 'complaint_suggestion', 'member'])
            ->where('member_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $latestTransactions = Transaction::where('status_id', 3)->latest()->get();

        return view('member.complaint_suggestions', compact('user', 'transactions', 'latestTransactions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'feedback'       => ['required'],
            'type'       => ['required'],
            // 'review'     => 'required|string|max:200',
            'transaction_id' => 'required|exists:transactions,id', // Pastikan transaksi valid
        ]);

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        ComplaintSuggestion::create([
            'feedback'          => $request->input('feedback'),
            'type'          => $request->input('type'),
            // 'review'        => $request->input('review'),
            'user_id'       => $user->id,
            'transaction_id' => $request->input('transaction_id'), // Simpan ID transaksi
            'reply'         => '',
        ]);

        return redirect()->route('member.complaints.index')
            ->with('success', 'Ulasan berhasil dikirim!');
    }



}
