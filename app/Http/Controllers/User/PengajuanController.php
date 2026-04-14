<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    /**
     * Halaman informasi pengajuan
     * (diajukan, disetujui, ditolak)
     */ 
    public function informasi()
    {
        $pengajuan = Peminjaman::with('details.buku')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['dipinjam', 'ditolak'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.informasi-pengajuan.index', compact('pengajuan'));
    }

    //esxport pdf 
    public function downloadPDF($id)
    {
        $pengajuan = Peminjaman::with('details.buku', 'user')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('user.informasi-pengajuan.pdf', compact('pengajuan'));

        return $pdf->download('bukti-peminjaman.pdf');
    }
    
}
