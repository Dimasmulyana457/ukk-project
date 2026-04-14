<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data user dengan role 'user' saja (anggota)
        $anggotas = User::where('role', 'user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.anggota.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', 'in:user'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        // Buat user baru (anggota)
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Pastikan role adalah 'user'
        ]);

        return redirect()->route('admin.anggota.index')
                        ->with('success', 'Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Optional: bisa dibuat untuk melihat detail anggota
        $anggota = User::where('role', 'user')->findOrFail($id);
        return view('admin.anggota.show', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data anggota berdasarkan ID dan pastikan role-nya 'user'
        $anggota = User::where('role', 'user')->findOrFail($id);
        
        return view('admin.anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ambil data anggota
        $anggota = User::where('role', 'user')->findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role' => ['required', 'in:user'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        // Update data anggota
        $anggota->name = $validated['name'];
        $anggota->email = $validated['email'];
        
        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $anggota->password = Hash::make($validated['password']);
        }
        
        $anggota->role = 'user'; // Pastikan role tetap 'user'
        $anggota->save();

        return redirect()->route('admin.anggota.index')
                        ->with('success', 'Data anggota berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data anggota
        $anggota = User::where('role', 'user')->findOrFail($id);
        
        // Hapus anggota
        $anggota->delete();

        return redirect()->route('admin.anggota.index')
                        ->with('success', 'Anggota berhasil dihapus');
    }
}