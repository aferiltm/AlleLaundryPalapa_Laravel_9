<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * View complaint suggestion page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = Auth::user();

        $review = Review::where([
            'balasan' => null,
        ])->get();

        // $complaints = Review::where([
        //     'type'  => 2,
        //     'reply' => null,
        // ])->get();

        $count = Review::whereNull('balasan', '')->count();

        return view('admin.review', compact('user', 'review', 'count'));
    }

    /**
     * Get complaint suggestion by id
     *
     * @param  \App\Models\ComplaintSuggestion $complaintSuggestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Review $review): JsonResponse
    {
         $review->load('transaction');
        return response()->json($review);
    }

    /**
     * Send complaint suggestion reply
     *
     * @param  \App\Models\ComplaintSuggestion $complaintSuggestion
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Review $review, Request $request): JsonResponse
    {
        $review->balasan = $request->input('balasan');
        $review->save();

        return response()->json();
    }
}
