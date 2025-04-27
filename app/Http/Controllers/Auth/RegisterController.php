<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterAdminRequest;
use App\Http\Requests\Auth\RegisterMemberRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Lang;

class RegisterController extends Controller
{
    /**
     * Method to show register view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): View
    {
        return view('auth.register');
    }

    /**
     * Method to register a new user
     *
     * @param  \App\Http\Requests\Auth\RegisterMemberRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterMemberRequest $request): RedirectResponse
    {
        // User::create($request->safe()->all());

        // return redirect()->route('login.show')
        //     ->with('success', Lang::get('auth.register_success'));
        // $data = $request->safe()->all();
        $data = $request->only(['name', 'email', 'phone_number', 'password']);
        $data['point'] = 20; // Default point untuk member baru
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('login.show')
            ->with('success', Lang::get('auth.register_success'));
    }
    // public function register(RegisterMemberRequest $request): RedirectResponse
    // {
    //     // Validate the request
    //     $request->validate([
    //         'phone_number' => 'required|string|unique:users,phone_number',
    //         'email' => 'required|email|unique:users,email',
    //         'name' => 'required|string|max:255',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);
    //     $data = $request->safe()->all();
    //     $data['point'] = 20; // Default point for new members
    //     $data['password'] = bcrypt($data['password']); // Hash the password
    //     User::create($data);

    //     return redirect()->route('login.show')
    //         ->with('success', Lang::get('auth.register_success'));
    // }

    public function rules()

    {

        return [

            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email',

            'phone_number' => 'required|string|unique:users,phone_number',

            'password' => 'required|string|min:8|confirmed',

        ];

    }



    /**
     * Method to show register admin view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function registerAdminView(): View
    {
        return view('auth.registerAdmin');
    }

    /**
     * Method to add new admin-level user
     *
     * @param  \App\Http\Requests\Auth\RegisterAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerAdmin(RegisterAdminRequest $request): RedirectResponse
    {
        // Check if secret key is the same
        if ($request->input('secret') != env('REGISTER_ADMIN_SECRET_KEY', 'admin123')) {
            return redirect()->route('register.admin')
                ->with('error', 'Secret key salah.');
        }

        $user = new User(
            $request->safe()->all()
        );
        $user->role = Role::Admin;
        $user->point = 20; // Default point untuk atmin baru
        $user->saveOrFail();

        return redirect()->route('login.show')
            ->with('success', Lang::get('auth.register_success'));
    }
}
