<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            // Siswa
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Petugas (boleh kosong jika online)
            $table->foreignId('petugas_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');

            $table->enum('status', [
                'diajukan',
                'dipinjam',
                'dikembalikan',
                'ditolak'
            ])->default('diajukan');

            $table->enum('metode', ['online', 'langsung']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
