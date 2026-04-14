<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
    'user_id',
    'buku_id',
    'no_telp',
    'tanggal_pinjam',
    'tanggal_kembali',
    'status',
    'metode',
    'petugas_id',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Relasi ke User (Anggota)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    /**
     * Relasi many-to-many ke tabel buku melalui detail_peminjaman
     */
    public function bukuDipinjam()
    {
        return $this->belongsToMany(Buku::class, 'detail_peminjaman', 'peminjaman_id', 'buku_id')
                    ->withTimestamps();
    }


}
