<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Show member view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = Auth::user();
        $members = User::where('role', 2)->get();

        return view('admin.members', compact('user', 'members'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => 2, // Role 2 untuk member
            'point' => 20, // Default point untuk member baru
            'password' => bcrypt('password123') // bisa diganti dengan password dari form
            // Tidak perlu isi user_code, akan di-generate otomatis di model
        ]);

        return redirect()->back()->with('success', 'Member berhasil ditambahkan.');
    }


}
