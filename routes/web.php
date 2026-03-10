<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Petugas\BarangController;
use App\Http\Controllers\Petugas\TransaksiController;
use App\Http\Controllers\Petugas\UserController;
use App\Http\Controllers\Pemilik\LaporanController;
use App\Http\Controllers\Anggota\SewaController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/',[LoginController::class,'form']);
Route::get('/login',[LoginController::class,'form'])->name('login');

Route::post('/login',[LoginController::class,'proses'])->name('login.proses');

Route::post('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/dashboard', function () {
    session(['role' => 'petugas']); // ganti pemilik / anggota
    return view('dashboard.index');
});

Route::get('/aktivasi/{token}', [App\Http\Controllers\Auth\AktivasiController::class, 'form']);
Route::post('/aktivasi/{token}', [App\Http\Controllers\Auth\AktivasiController::class, 'proses']);


Route::middleware(['auth','role:pemilik'])->prefix('pemilik')->group(function(){

Route::get('/laporan-sewa',[LaporanController::class,'sewa']);
Route::get('/laporan-denda',[LaporanController::class,'denda']);
Route::get('/laporan-kerusakan',[LaporanController::class,'kerusakan']);

});

Route::middleware(['auth','role:petugas'])->prefix('petugas')->group(function(){

    Route::get('/dipinjam', [TransaksiController::class,'dipinjam'])->name('transaksi.dipinjam');

    Route::delete('/hapus/{id}', [TransaksiController::class,'hapus'])->name('transaksi.hapus');

    Route::get('/kembalikan/{id}', [TransaksiController::class,'formKembalikan'])->name('transaksi.formKembalikan');

    Route::post('/kembalikan/{id}', [TransaksiController::class,'prosesKembalikan'])->name('transaksi.prosesKembalikan');

    Route::get('/terdenda',[TransaksiController::class,'terdenda'])->name('transaksi.terdenda');

    Route::post('/{id}/lunas',[TransaksiController::class,'lunas'])->name('transaksi.lunas');

    Route::get('/selesai',[TransaksiController::class,'selesai'])->name('transaksi.selesai');

    Route::get('/tersewa',[TransaksiController::Class,'tersewa'])->name('transaksi.tersewa');

    Route::post('/tersewa/{id}', [TransaksiController::class,'diambil'])->name('transaksi.diambil');

    Route::get('/selesai/{id}',[TransaksiController::class,'notaSelesai'])->name('transaksi.notaSelesai');

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

});

Route::middleware(['auth','role:anggota'])->prefix('anggota')->group(function(){

    Route::get('/sewa',[SewaController::class,'index'])->name('anggota.sewa');

    Route::get('/riwayat',[SewaController::class,'riwayat'])->name('anggota.riwayat');

    Route::get('/profil',[SewaController::class,'profil'])->name('anggota.profil');

});
