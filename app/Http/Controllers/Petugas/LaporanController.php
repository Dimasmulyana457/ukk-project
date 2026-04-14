<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'bukuDipinjam']);

        // FILTER BULAN
        if ($request->filled('bulan')) {
            $bulan = date('m', strtotime($request->bulan));
            $tahun = date('Y', strtotime($request->bulan));

            $query->whereMonth('tanggal_pinjam', $bulan)
                ->whereYear('tanggal_pinjam', $tahun);
        } 
        // FILTER TANGGAL
        else {
            if ($request->filled('dari')) {
                $query->whereDate('tanggal_pinjam', '>=', $request->dari);
            }

            if ($request->filled('sampai')) {
                $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
            }
        }

        $peminjaman = $query->latest()->paginate(5)->withQueryString();

        return view('petugas.laporan.index', compact('peminjaman'));
    }
    public function export(Request $request)
{
    $query = Peminjaman::with(['user', 'bukuDipinjam']);

    // FILTER BULAN
    if ($request->filled('bulan')) {
        $bulan = date('m', strtotime($request->bulan));
        $tahun = date('Y', strtotime($request->bulan));

        $query->whereMonth('tanggal_pinjam', $bulan)
              ->whereYear('tanggal_pinjam', $tahun);
    } else {
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }
    }

    $data = $query->latest()->get();

    $filename = "laporan_petugas.xls";

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function () use ($data) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
              </tr>";

        foreach ($data as $i => $item) {
            echo "<tr>
                    <td>".($i+1)."</td>
                    <td>{$item->user->name}</td>
                    <td>".$item->bukuDipinjam->pluck('kode_buku')->join(', ')."</td>
                    <td>".$item->bukuDipinjam->pluck('judul')->join(', ')."</td>
                    <td>{$item->tanggal_pinjam}</td>
                    <td>".($item->tanggal_kembali ?? '-')."</td>
                    <td>{$item->status}</td>
                  </tr>";
        }

        echo "</table>";
    };

    return response()->stream($callback, 200, $headers);
}
}