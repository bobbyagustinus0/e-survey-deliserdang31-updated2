<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Login menggunakan username ATAU email
        $loginField = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $attempt = Auth::attempt(
            [$loginField => $credentials['username'], 'password' => $credentials['password']],
            $request->boolean('remember')
        );

        if ($attempt) {
            $user = Auth::user();

            if ($user->status !== 'aktif') {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun anda tidak aktif. Hubungi administrator.']);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return back()->withErrors(['username' => 'Username/Email atau password salah.'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
