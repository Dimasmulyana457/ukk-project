<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pengembalian;
use App\Models\ActivityLog;

class PengembalianController extends Controller
{
    /**
     * Tampilkan daftar buku yang sedang dipinjam
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'bukuDipinjam'])
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_pinjam', 'asc')
            ->get();

        return view('petugas.pengembalian.index', compact('peminjaman'));
    }
        /**
         * Proses pengembalian buku
         */
        public function kembalikan(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('bukuDipinjam')->findOrFail($id);

        DB::transaction(function () use ($peminjaman, $request) {

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()
            ]);

            foreach ($peminjaman->bukuDipinjam as $buku) {
                $buku->increment('stok', 1);
            }

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_dikembalikan' => now(),
                'denda' => $request->denda ?? 0,
                'keterangan' => $request->keterangan ?? 'Dikembalikan'
            ]);
        });

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mengembalikan buku + denda Rp' . ($request->denda ?? 0)
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
