<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintSuggestion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintSuggestionController extends Controller
{
    /**
     * View complaint suggestion page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = Auth::user();

        $suggestions = ComplaintSuggestion::where('type', 'Saran')
            ->where(function($q) {
                $q->whereNull('reply')->orWhere('reply', '');
            })
            ->with('transaction', 'user')
            ->get();

        $complaints = ComplaintSuggestion::where('type', 'Komplain')
            ->where(function($q) {
                $q->whereNull('reply')->orWhere('reply', '');
            })
            ->with('transaction', 'user')
            ->get();


        $count = $suggestions->count() + $complaints->count();

        return view('admin.complaint_suggestion', compact('user', 'suggestions', 'complaints', 'count'));
    }



    /**
     * Get complaint suggestion by id
     *
     * @param  \App\Models\ComplaintSuggestion $complaintSuggestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ComplaintSuggestion $complaintSuggestion): JsonResponse
    {
         $complaintSuggestion->load('transaction');
        return response()->json($complaintSuggestion);
    }

    /**
     * Send complaint suggestion reply
     *
     * @param  \App\Models\ComplaintSuggestion $complaintSuggestion
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ComplaintSuggestion $complaintSuggestion): JsonResponse
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $complaintSuggestion->reply = $request->input('reply');
        $complaintSuggestion->save();

        return response()->json(['message' => 'Reply saved successfully.']);
    }

}
