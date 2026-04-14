<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Peminjaman;
use App\Models\Buku;

class KelolaPeminjamanController extends Controller
{
    /**
     * Tampilkan semua pengajuan (status: diajukan)
     */
    public function index()
    {
        $pengajuan = Peminjaman::with(['user', 'buku'])
            ->where('status', 'diajukan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('petugas.kelola-pengajuan.index', compact('pengajuan'));
    }

    /**
     * Terima pengajuan
     */
    public function terima($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'dipinjam',
            'petugas_id' => Auth::id() // 🔥 ini kuncinya
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
             'aktivitas' => 'Meminjamkan buku ke ' . $peminjaman->user->name
        ]);

        return back()->with('success', 'Pengajuan berhasil diterima');
    }

    /**
     * Tolak pengajuan
     */
    public function tolak($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        // kembalikan stok semua buku yang diajukan
        foreach ($peminjaman->details as $detail) {
            Buku::where('id', $detail->buku_id)->increment('stok', 1);
        }

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak dan stok buku dikembalikan');
    }

}
