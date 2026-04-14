<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM LOGIN
    public function loginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // CEK ROLE
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        if (Auth::user()->role === 'user') {
            return redirect()->route('user.katalog');
        }


        // USER BIASA
        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah'
    ]);
}
    // FORM LOGIN
    public function registerForm()
    {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user', // default user
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function profil()
{
    return view('profil');
}

public function updateProfil(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'no_telp' => 'nullable'
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'no_telp' => $request->no_telp
    ]);

    return back()->with('success', 'Profil berhasil diperbarui');
}
}
