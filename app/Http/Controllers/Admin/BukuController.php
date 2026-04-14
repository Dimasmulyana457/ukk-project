<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Tampilkan daftar buku
     */
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('admin.buku.index', compact('buku'));
    }

    /**
     * Form tambah buku
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    /**
     * Simpan buku baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku'   => 'required|unique:buku,kode_buku|max:255',
            'judul'       => 'required|max:255',
            'pengarang'   => 'required|max:255',
            'penerbit'    => 'required|max:255',
            'tahun_terbit'=> 'required|integer|min:1900|max:2099',
            'kategori_id' => 'required|exists:kategori,id',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'kode_buku.required' => 'Kode buku wajib diisi',
            'kode_buku.unique'   => 'Kode buku sudah digunakan',
            'judul.required'     => 'Judul buku wajib diisi',
            'pengarang.required' => 'Pengarang wajib diisi',
            'penerbit.required'  => 'Penerbit wajib diisi',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi',
            'kategori_id.required'  => 'Kategori wajib dipilih',
            'stok.required'      => 'Stok wajib diisi',
            'gambar.image'       => 'File harus berupa gambar',
            'gambar.max'         => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->storeAs('buku', $namaFile, 'public'); 
            $validated['gambar'] = $namaFile;
        }


        Buku::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambahkan buku "' . $validated['judul'] . '"'
        ]);

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Form edit buku
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();

        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update data buku
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'kode_buku'   => 'required|max:255|unique:buku,kode_buku,' . $id,
            'judul'       => 'required|max:255',
            'pengarang'   => 'required|max:255',
            'penerbit'    => 'required|max:255',
            'tahun_terbit'=> 'required|integer|min:1900|max:2099',
            'kategori_id' => 'required|exists:kategori,id',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($buku->gambar && Storage::exists('public/buku/'.$buku->gambar)) {
                Storage::delete('public/buku/'.$buku->gambar);
            }

            $file = $request->file('gambar');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->storeAs('buku', $namaFile, 'public');
            $validated['gambar'] = $namaFile;
        }

        $buku->update($validated);

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    /**
     * Hapus buku
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar && Storage::disk('public')->exists('buku/'.$buku->gambar)) {
            Storage::disk('public')->delete('buku/'.$buku->gambar);
        }


        $buku->delete();

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus');
    }

    
}
