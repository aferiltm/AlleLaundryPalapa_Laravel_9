<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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

        $allreview = Review::with('user')->get(); // Semua ulasan
        $userreview = Review::where('user_id', $user->id)->get();

        return view('member.review', [
            'user' => $user,
            'review' => $userreview,
            'allReview' => $allreview,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'review'     => 'required|string|max:200',
            'transaction_id' => 'required|exists:transactions,id', // Pastikan transaksi valid
        ]);

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        Review::create([
            'review'          => $request->input('review'),
            'rating'        => $request->input('rating'),
            'user_id'       => $user->id,
            'transaction_id' => $request->input('transaction_id'), // Simpan ID transaksi
            'reply'         => '',
        ]);

        return redirect()->route('member.review.index')
            ->with('success', 'Ulasan/Review berhasil dikirim!');
    }


}
