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
            'type'           => ['required'],
            'transaction_id' => ['required', 'exists:transactions,id'],
        ]);

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        // Cek apakah user sudah pernah mengirim komplain untuk transaksi ini
        $alreadyExists = ComplaintSuggestion::where('user_id', $user->id)
            ->where('transaction_id', $request->transaction_id)
            ->exists();

        if ($alreadyExists) {
            return redirect()->back()->with('error', 'Anda sudah mengirim feedback untuk transaksi ini.');
        }

        ComplaintSuggestion::create([
            'feedback'       => $request->input('feedback'),
            'type'           => $request->input('type'),
            'user_id'        => $user->id,
            'transaction_id' => $request->input('transaction_id'),
            'reply'          => '',
        ]);

        return redirect()->back()->with('success', 'Komplain berhasil dikirim.');
    }





}
