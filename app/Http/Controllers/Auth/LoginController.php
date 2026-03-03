<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Auth/Login');
    }

    /**
     * Tampilkan halaman register.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Auth/Register');
    }

    /**
     * Proses autentikasi user.
     */
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]); 

        // Cek input apakah email atau username
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Susun credentials secara dinamis
        $credentials = [
            $fieldType => $request->login,
            'password' => $request->password,
        ];

        // Login (menggunakan username & password)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard berdasarkan role user
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('adminDashboard'));
            } else {
                return redirect()->intended(route('userDashboard'));
            }
            return redirect()->route('login');  
        }

        // Jika Gagal, kembali ke Vue
        throw ValidationException::withMessages([
            'loginError' => 'Credentials login tidak sesuai.',
        ]);
    }

    /**
     * Proses registrasi user baru (member).
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users,username'],
            'phone' => 'required|string|max:20',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'member',
        ]);
        
        return redirect()->route('login')->with('message', 'Registrasi berhasil. Silakan login.');
    }

    /**
     * Proses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
