<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ComplaintSuggestion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $allComplaintSuggestions = ComplaintSuggestion::with('user')->get(); // Semua ulasan
        $userComplaintSuggestions = ComplaintSuggestion::where('user_id', $user->id)->get();

        return view('member.complaint_suggestions', [
            'user' => $user,
            'complaintSuggestions' => $userComplaintSuggestions,
            'allComplaintSuggestions' => $allComplaintSuggestions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'feedback'       => ['required'],
            'type'       => ['required'],
            'rating'     => 'required|integer|min:1|max:5',
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
            'rating'        => $request->input('rating'),
            // 'review'        => $request->input('review'),
            'user_id'       => $user->id,
            'transaction_id' => $request->input('transaction_id'), // Simpan ID transaksi
            'reply'         => '',
        ]);

        return redirect()->route('member.complaints.index')
            ->with('success', 'Ulasan berhasil dikirim!');
    }


}
