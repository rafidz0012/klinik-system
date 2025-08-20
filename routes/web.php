<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\TindakanKunjunganController;
use App\Http\Controllers\ObatKunjunganController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('wilayah', WilayahController::class);
    Route::resource('user', UserController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('tindakan', TindakanController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('tindakan-kunjungan', TindakanKunjunganController::class);
    Route::resource('obat-kunjungan', ObatKunjunganController::class);
    Route::resource('kunjungan', KunjunganController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('roles', RolesController::class)->except(['create', 'show', 'edit']);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

