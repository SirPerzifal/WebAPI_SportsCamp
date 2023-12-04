<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarBankController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JenisLapanganController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\NotActiveAccountController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\PenyediaLapanganController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekRole;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function(){
    Route::get('/', ([UserController::class,'showLandingPage']))
    ->name('landingPage');

    Route::get('/login', ([AuthController::class,'showLoginPage']))
    ->name('loginPage');

    Route::post('/proses-login', ([AuthController::class, 'loginProcess']))
    ->name('loginProcess');

    Route::get('/register', ([RegisterController::class,'showRegisterPage']))
    ->name('registerPage');

    Route::post('/register/penyedia', ([RegisterController::class,'registerPenyedia']))
    ->name('registerPenyedia');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout', ([AuthController::class, 'logout']))
    ->name('logout');

    Route::get('/akun-belum-aktif',([NotActiveAccountController::class,'notActivePage']))
    ->name('accountNotActive');

    Route::put('/user/{id_user}/change-password',([UserController::class,'updateKataSandi']))
    ->name('updateKataSandi');

    Route::get('/tes', ([PemesananController::class,'tes']))
    ->name('tes');
});

Route::middleware(['cekstatus', 'cekrole:penyedia'])->group(function () {
    Route::get('/dashboard/penyedia', ([DashboardController::class,'penyediaDashboard']))
    ->name('dashboardPage');

    Route::get('/penarikan', ([PenarikanController::class,'showPenarikanPage']))
    ->name('penarikanPage');

    Route::post('/penarikan/ajukan', ([PenarikanController::class,'pengajuanPenarikan']))
    ->name('pengajuanPenarikan');

    Route::get('/riwayat/penarikan', ([PenarikanController::class,'showRiwayatPenarikanPage']))
    ->name('riwayatPenarikanPage');

    Route::get('/riwayat/pemesanan', ([PemesananController::class,'showRiwayatPemesananPage']))
    ->name('riwayatPemesananPage');

    Route::get('/lapangan', ([LapanganController::class,'showLapanganPage']))
    ->name('lapanganPage');

    Route::post('/lapangan/tambah', ([LapanganController::class,'tambahLapangan']))
    ->name('tambahLapangan');

    Route::put('/lapangan/{id_lapangan}/edit', ([LapanganController::class,'editLapangan']))
    ->name('editLapangan');

    Route::delete('/lapangan/{id_lapangan}/hapus', ([LapanganController::class,'hapusLapangan']))
    ->name('hapusLapangan');

    Route::put('/lapangan/jadwal/{id_jadwal}/edit', ([JadwalController::class,'editJadwalLapangan']))
    ->name('editJadwalLapangan');

    Route::delete('/lapangan/jadwal/{id_jadwal}/hapus', ([JadwalController::class,'hapusJadwalLapangan']))
    ->name('hapusJadwalLapangan');

    Route::get('/profile/penyedia', ([PenyediaLapanganController::class,'showProfile']))
    ->name('profilePenyedia');

    Route::put('/profile/penyedia/{id_user}/update-profile', ([PenyediaLapanganController::class,'updateProfile']))
    ->name('updateProfilePenyedia');

    Route::put('/profile/penyedia/{id_penyedia_lapangan}/update-rekening', ([RekeningController::class,'updateRekeningPenyedia']))
    ->name('updateRekening');
});

Route::middleware(CekRole::class . ':admin')->group(function(){
    Route::get('/dashboard/admin', ([DashboardController::class,'adminDashboard']))
    ->name('adminDashboardPage');

    Route::put('/dashboard/admin/{id_user}/edit-status', ([UserController::class,'updateStatus']))
    ->name('editStatusPenyedia');

    Route::get('/profile/admin', ([AdminController::class,'showProfile']))
    ->name('profileAdmin');

    Route::put('/profile/admin/{id_user}/edit', ([AdminController::class,'updateProfile']))
    ->name('updateProfileAdmin');

    Route::get('/validasi/penarikan', ([PenarikanController::class,'showValidasiPenarikan']))
    ->name('validasiPenarikanPage');

    Route::put('/validasi/penarikan/{id_penarikan}', ([PenarikanController::class,'validasiPenarikan']))
    ->name('validasiPenarikan');

    Route::get('/validasi/pemesanan', ([PemesananController::class,'showValidasiPemesanan']))
    ->name('validasiPemesananPage');

    Route::put('/validasi/pemesanan', ([PemesananController::class,'validasiPemesanan']))
    ->name('validasiPemesanan');

    Route::get('/riwayat/validasi/penarikan', ([PenarikanController::class,'showRiwayatValidasiPenarikanPage']))
    ->name('riwayatValidasiPenarikanPage');

    Route::get('/riwayat/validasi/pemesanan', ([PemesananController::class,'showRiwayatValidasiPemesananPage']))
    ->name('riwayatValidasiPemesananPage');
});

Route::middleware(CekRole::class . ':superadmin')->group(function(){
    Route::get('/change-password/superadmin', ([SuperadminController::class,'showChangePasswordPage']))
    ->name('superadminChangePasswordPage');

    Route::get('/dashboard/superadmin', ([DashboardController::class,'superadminDashboard']))
    ->name('superadminDashboardPage');

    Route::post('/dashboard/superadmin/tambah-admin', ([AdminController::class,'tambahAdmin']))
    ->name('tambahAdmin');

    Route::put('/dashboard/superadmin/{id_user}/edit-admin', ([AdminController::class,'editAdmin']))
    ->name('editAdmin');

    Route::delete('/dashboard/superadmin/{id_user}/hapus-admin', ([AdminController::class,'hapusAdmin']))
    ->name('hapusAdmin');

    Route::get('/daftar-bank', ([DaftarBankController::class,'showDaftarBank']))
    ->name('daftarBank');

    Route::post('/daftar-bank/tambah', ([DaftarBankController::class,'tambahDaftarBank']))
    ->name('tambahDaftarBank');

    Route::put('/daftar-bank/{kode_bank}/edit', ([DaftarBankController::class,'editDaftarBank']))
    ->name('editDaftarBank');

    Route::delete('/daftar-bank/{kode_bank}/hapus', ([DaftarBankController::class,'hapusDaftarBank']))
    ->name('hapusDaftarBank');

    Route::get('/jenis-lapangan', ([JenisLapanganController::class,'showJenisLapangan']))
    ->name('jenisLapangan');

    Route::post('/jenis-lapangan/tambah', ([JenisLapanganController::class,'tambahJenisLapangan']))
    ->name('tambahJenisLapangan');

    Route::put('/jenis-lapangan/{id_jenis_lapangan}/edit', ([JenisLapanganController::class,'editJenisLapangan']))
    ->name('editJenisLapangan');

    Route::delete('/jenis-lapangan/{id_jenis_lapangan}/hapus', ([JenisLapanganController::class,'hapusJenisLapangan']))
    ->name('hapusJenisLapangan');

    Route::get('/metode-pembayaran', ([MetodePembayaranController::class,'showMetodePembayaran']))
    ->name('metodePembayaran');

    Route::post('/metode-pembayaran', ([MetodePembayaranController::class,'tambahMetodePembayaran']))
    ->name('tambahMetodePembayaran');

    Route::put('/metode-pembayaran/{id_metode_pembayaran}/edit', ([MetodePembayaranController::class,'editMetodePembayaran']))
    ->name('editMetodePembayaran');

    Route::delete('/metode-pembayaran/{id_metode_pembayaran}/hapus', ([MetodePembayaranController::class,'hapusMetodePembayaran']))
    ->name('hapusMetodePembayaran');
});
