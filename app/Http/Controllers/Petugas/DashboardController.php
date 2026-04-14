<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // 📈 GRAFIK
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

        // 🔥 JATUH TEMPO (hari ini)
        $jatuhTempo = Peminjaman::with('buku', 'user')
            ->whereDate('tanggal_kembali', Carbon::today())
            ->where('status', 'dipinjam')
            ->get();

        $jumlahJatuhTempo = $jatuhTempo->count();

        // 🔥 TERLAMBAT
        $terlambat = Peminjaman::with('buku', 'user')
            ->where('tanggal_kembali', '<', Carbon::today())
            ->where('status', 'dipinjam')
            ->get();

        $jumlahTerlambat = $terlambat->count();

        return view('petugas.dashboard.index', compact(
            'dipinjam',
            'labels',
            'data',
            'jatuhTempo',
            'terlambat',
            'jumlahJatuhTempo',
            'jumlahTerlambat'
        ));
    }
}