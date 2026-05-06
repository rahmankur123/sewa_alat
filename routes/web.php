<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Petugas\BarangController;
use App\Http\Controllers\Petugas\TransaksiController;
use App\Http\Controllers\Petugas\UserController;
use App\Http\Controllers\User\SewaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;



Route::get('/',[LoginController::class,'form']);
Route::get('/login',[LoginController::class,'form'])->name('login');

Route::post('/login',[LoginController::class,'proses'])->name('login.proses');

Route::post('/logout',[LoginController::class,'logout'])->name('logout');


Route::get('/aktivasi/{token}', [App\Http\Controllers\Auth\AktivasiController::class, 'form']);
Route::post('/aktivasi/{token}', [App\Http\Controllers\Auth\AktivasiController::class, 'proses']);


Route::middleware(['auth','role:pemilik'])->prefix('pemilik')->group(function(){

Route::get('/dashboard',[DashboardController::class,'admin']);
Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');


});

Route::middleware(['auth','role:petugas'])->prefix('petugas')->group(function(){


    Route::get('/dashboard',[DashboardController::class,'admin']);

    Route::get('/transaksi/create', [TransaksiController::class,'create'])->name('petugas.transaksi.create');

    Route::post('/transaksi/create', [TransaksiController::class,'store'])->name('petugas.transaksi.store');

    Route::get('/transaksi/dipinjam', [TransaksiController::class,'dipinjam'])->name('petugas.transaksi.dipinjam');

    Route::delete('/transaksi/hapus/{id}', [TransaksiController::class,'hapus'])->name('petugas.transaksi.hapus');

    Route::get('/transaksi/kembalikan/{id}', [TransaksiController::class,'formKembalikan'])->name('petugas.transaksi.formKembalikan');

    Route::post('/transaksi/kembalikan/{id}', [TransaksiController::class,'prosesKembalikan'])->name('petugas.transaksi.prosesKembalikan');

    Route::get('/transaksi/terdenda',[TransaksiController::class,'terdenda'])->name('petugas.transaksi.terdenda');

    Route::get('/transaksi/terdenda/{id}/detail',[TransaksiController::class,'detailDenda'])->name('petugas.transaksi.detailDenda');

    Route::post('/transaksi/{id}/lunas',[TransaksiController::class,'lunas'])->name('petugas.transaksi.lunas');

    Route::get('/transaksi/selesai',[TransaksiController::class,'selesai'])->name('petugas.transaksi.selesai');

    Route::get('/transaksi/tersewa',[TransaksiController::class,'tersewa'])->name('petugas.transaksi.tersewa');

    Route::get('/transaksi/hilang',[TransaksiController::class,'barangHilang'])->name('petugas.transaksi.hilang');

    Route::post('/transaksi/tersewa/{id}', [TransaksiController::class,'diambil'])->name('petugas.transaksi.diambil');

    Route::get('/transaksi/selesai/{id}/nota',[TransaksiController::class,'notaSelesai'])->name('petugas.transaksi.notaSelesai');

    Route::get('/transaksi/selesai/{id}/detail',[TransaksiController::class,'detailSelesai'])->name('petugas.transaksi.detailSelesai');

    Route::get('/transaksi/terdenda/{id}',[TransaksiController::class,'notaDenda'])->name('petugas.transaksi.notaDenda');

    Route::get('/transaksi/detail/{id}', [TransaksiController::class,'detail'])->name('petugas.transaksi.detail');

    Route::get('/transaksi/show/{id}', [TransaksiController::class,'show'])->name('petugas.transaksi.show');

    Route::resource('barang', BarangController::class)->names([
        'index' => 'barang.index',
        'create' => 'barang.create',
        'store' => 'barang.store',
        'edit' => 'barang.edit',
        'update' => 'barang.update',
        'destroy' => 'barang.destroy',
    ]);
    Route::resource('user', UserController::class)->names([
    'index' => 'user.index',
    'create' => 'user.create',
    'store' => 'user.store',
    'edit' => 'user.edit',
    'update' => 'user.update',
    'destroy' => 'user.destroy',
    ]);

    Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');


});

Route::middleware(['auth','role:anggota'])->prefix('anggota')->group(function(){

    Route::get('/dashboard',[DashboardController::class,'anggota'])->name('anggota.dashboard');

    Route::get('/sewa',[SewaController::class,'index'])->name('anggota.sewa');

    Route::post('/sewa',[SewaController::class,'store'])->name('sewa.store');

    Route::get('/profil', [UserController::class, 'editProfil'])->name('profil.edit');

    Route::put('/profil', [UserController::class, 'updateProfil'])->name('profil.update');

    Route::get('/riwayat/tersewa',[SewaController::class,'tersewa'])->name('riwayat.tersewa');

    Route::get('/riwayat/dipinjam',[SewaController::class,'dipinjam'])->name('riwayat.dipinjam');

    Route::get('/riwayat/terdenda',[SewaController::class,'terdenda'])->name('riwayat.terdenda');

    Route::get('/riwayat/hilang',[SewaController::class,'Hilang'])->name('riwayat.hilang');

    Route::get('/riwayat/selesai',[SewaController::class,'selesai'])->name('riwayat.selesai');

    Route::get('/riwayat/detail/{id}', [SewaController::class,'detail'])->name('anggota.riwayat.detail');

    Route::get('/riwayat/detaildenda/{id}', [SewaController::class,'detailDenda'])->name('anggota.riwayat.detaildenda');

    Route::get('/riwayat/detailselesai/{id}', [SewaController::class,'detailSelesai'])->name('anggota.riwayat.detailselesai');

    Route::delete('/riwayat/hapus/{id}', [SewaController::class,'hapus'])->name('anggota.riwayat.hapus');


});
