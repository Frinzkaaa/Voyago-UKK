<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Enums\UserStatus;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check plain text password as per user request
        if ($user && $user->password === $request->password) {
            Auth::login($user);

            if ($user->role === UserRole::ADMIN) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === UserRole::PARTNER) {
                return redirect()->route('partner.dashboard');
            }

            return redirect()->route('beranda');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Plain text as requested
            'role' => UserRole::USER,
            'status' => UserStatus::ACTIVE,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login untuk melanjutkan.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
