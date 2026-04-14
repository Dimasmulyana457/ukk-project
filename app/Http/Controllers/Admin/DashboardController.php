<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stok');
        $totalAnggota = User::where('role', 'user')->count();

        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();

        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->count();

        // 🔥 HITUNG BUKU TERSEDIA
        $tersedia = $totalStok - $dipinjam;

        // 🔥 GRAFIK PEMINJAMAN
        $peminjamanPerBulan = Peminjaman::select(
                DB::raw('MONTH(tanggal_pinjam) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0,0,0,$i,1));
            $data[] = $peminjamanPerBulan[$i] ?? 0;
        }

        $peminjamAktif = Peminjaman::with(['user', 'buku'])
        ->where('status', 'dipinjam')
        ->latest()
        ->get();

        return view('admin.dashboard.index', compact(
            'totalBuku',
            'totalStok',
            'totalAnggota',
            'dipinjam',
            'terlambat',
            'labels',
            'data',
            'tersedia',
            'peminjamAktif'
        ));
    }
}