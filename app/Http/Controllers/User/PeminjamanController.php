<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Halaman form ajukan peminjaman (MULTI BUKU)
     */
    public function indexMulti(Request $request)
    {
        // Validasi minimal ada 1 buku yang dipilih
        $bukuIds = $request->input('buku_ids', []);
        
        if (empty($bukuIds)) {
            return redirect()->route('user.katalog')
                ->with('error', 'Silakan pilih minimal 1 buku untuk dipinjam');
        }

        // Ambil data buku yang dipilih
        $bukus = Buku::whereIn('id', $bukuIds)->get();

        // Validasi semua buku harus tersedia
        if ($bukus->count() !== count($bukuIds)) {
            return redirect()->route('user.katalog')
                ->with('error', 'Beberapa buku yang dipilih tidak ditemukan');
        }

        return view('user.peminjaman.index', [
            'bukus' => $bukus,
            'user' => Auth::user()
        ]);
    }

    /**
     * Halaman form ajukan peminjaman (SINGLE BUKU - untuk backward compatibility)
     */
    public function index(Buku $buku)
    {
        return view('user.peminjaman.index', [
            'bukus' => collect([$buku]), // Wrap dalam collection
            'user' => Auth::user()
        ]);
    }

    /**
     * Simpan peminjaman (MULTI BUKU)
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        //valida no telp kalo kosong
        if (!Auth::user()->no_telp) {
            return back()->withErrors([
                'no_telp' => 'Silakan isi nomor telepon di profil terlebih dahulu'
            ])->withInput();
        }

        // Cek apakah user sudah mengajukan di tanggal yang sama
        $cek = Peminjaman::where('user_id', Auth::id())
            ->where('tanggal_pinjam', $request->tanggal_pinjam)
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->exists();

        if ($cek) {
            return back()->withErrors([
                'tanggal_pinjam' => 'Anda sudah mengajukan peminjaman pada tanggal ini'
            ])->withInput();
        }

        // Cek stok semua buku
        $bukus = Buku::whereIn('id', $request->buku_ids)->get();
        
        foreach ($bukus as $buku) {
            if ($buku->stok < 1) {
                return back()->withErrors([
                    'buku_ids' => "Stok buku '{$buku->judul}' tidak mencukupi"
                ])->withInput();
            }
        }

        try {
            DB::beginTransaction();

            // Simpan peminjaman (tanpa buku_id di tabel peminjaman)
            $peminjaman = Peminjaman::create([
                'user_id' => Auth::id(),
                'buku_id' => null, // Set null karena buku disimpan di detail_peminjaman
                'no_telp' => Auth::user()->no_telp,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'diajukan',
                'metode' => 'online',
            ]);

            // Simpan detail peminjaman untuk setiap buku
            foreach ($request->buku_ids as $bukuId) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $bukuId,
                ]);

                // Kurangi stok buku
                Buku::where('id', $bukuId)->decrement('stok', 1);
            }

            DB::commit();

            return redirect()->route('user.katalog')
                ->with('success', 'Peminjaman ' . count($request->buku_ids) . ' buku berhasil diajukan');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan peminjaman: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function pengajuan()
    {
        $pengajuan = Peminjaman::with('bukuDipinjam')
            ->where('user_id', Auth::id())
            ->where('status', 'diajukan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pengajuan.index', compact('pengajuan'));
    }

    public function riwayat()
    {
         $riwayat = Peminjaman::with('details.buku')
                ->where('user_id', auth()->id())
                ->whereIn('status', ['dikembalikan', 'ditolak'])
                ->orderBy('created_at', 'desc')
                ->get();

        return view('user.riwayat.index', compact('riwayat'));
    }

}