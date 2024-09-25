<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check() && admin()->status == 1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function loginCheck(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $check = Admin::where('email', $request->email)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('admin')->attempt($credentials)) {
                    session()->flash('success', 'Welcome Back');
                    return redirect()->route('admin.dashboard');
                }
                session()->flash('error', 'Invalid credentials');
            } else {
                session()->flash('warning', 'Your account has been disabled. Please contact support.');
            }
        } else {
            session()->flash('error', 'Data not found in our record');
        }
        return redirect()->route('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
