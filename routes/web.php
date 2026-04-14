<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\User\KatalogController;
use App\Http\Controllers\User\PeminjamanController;
use App\Http\Controllers\User\PengajuanController;
use App\Http\Controllers\Petugas\LaporanController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Petugas\KelolaPeminjamanController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/sidebar', function () {
        return view('layouts.sidebar');
    })->name('sidebar');

    Route::get('/profil', [AuthController::class, 'profil'])->name('profil');
    Route::post('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');
});

//ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        
        Route::resource('/anggota', AnggotaController::class);
        
        Route::resource('/buku', BukuController::class);

        Route::get('/laporan', [AdminLaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/export', [AdminLaporanController::class, 'export'])
            ->name('laporan.export');

        Route::get('/activity-log', [ActivityLogController::class, 'index'])
            ->name('activity-log');
        
        

    });

//PETUGAS
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        Route::get('/dashboard', [PetugasDashboard::class, 'index'])
            ->name('dashboard');
        
        Route::get('/kelola-pengajuan', 
        [KelolaPeminjamanController::class, 'index']
        )->name('kelola.pengajuan');

        Route::post('/pengajuan/{id}/terima', 
            [KelolaPeminjamanController::class, 'terima']
        )->name('pengajuan.terima');

        Route::post('/pengajuan/{id}/tolak', 
            [KelolaPeminjamanController::class, 'tolak']
        )->name('pengajuan.tolak');

        Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->name('pengembalian.index');

        Route::post('/pengembalian/{id}', [PengembalianController::class, 'kembalikan'])
        ->name('pengembalian.kembalikan');

         Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

        Route::get('/laporan/export', [PetugasLaporanController::class, 'export'])
        ->name('laporan.export');

        
    });
    
//USER
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/katalog', [KatalogController::class, 'index'])
        ->name('katalog');
        
        Route::get('/pengajuan', [PeminjamanController::class, 'pengajuan'])
        ->name('pengajuan');

        Route::get('/peminjaman/multi', [PeminjamanController::class, 'indexMulti'])
        ->name('peminjaman.index.multi');

        Route::post('/peminjaman/ajukan', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

         Route::get('/peminjaman/{buku}', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

         Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

        Route::get('/informasi-pengajuan', [PengajuanController::class, 'informasi'])
        ->name('informasi-pengajuan');

        Route::get('/pengajuan/{id}/download', [PengajuanController::class, 'downloadPDF'])
        ->name('pengajuan.download');

        Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])
        ->name('riwayat');

        



});
