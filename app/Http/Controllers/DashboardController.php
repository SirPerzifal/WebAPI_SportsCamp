<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\daftar_bank;
use App\Models\jenis_lapangan;
use App\Models\lapangan;
use App\Models\pemesanan;
use App\Models\penarikan;
use App\Models\penyedia_lapangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superadminDashboard(){
        $admin = admin::latest()->get();
        $daftar_bank = daftar_bank::all();
        $jenis_lapangan = jenis_lapangan::all();

        return view('superadmin.dashboard',[
            'dataAdmin' => $admin,
            'daftarBank' => $daftar_bank,
            'dataLapangan' => $jenis_lapangan,
        ]);
    }

    public function adminDashboard(){
        $penyedia = User::where('role','penyedia')->orderBy('status','asc')->latest()->get();
        $penarikan = penarikan::where('status','sedang diproses')->get();
        $pemesanan = pemesanan::where('status','pending')->get();

        return view('admin.dashboard', [
            'dataPenyedia' => $penyedia,
            'dataPenarikan' => $penarikan,
            'dataPemesanan' => $pemesanan,
        ]);
    }


    public function penyediaDashboard(){
        $user = Auth::user()->penyedia;

        // Menggunakan eager loading untuk mengambil data penarikan dan lapangan
        $user->load(['penarikan', 'lapangan.pemesanan']);

        $jumlahPenarikan = $user->penarikan->where('status', 'selesai')->sum('jumlah_penarikan');

        $jumlahPemesananBerhasil = $user->lapangan->flatMap(function ($lap) {
            return $lap->pemesanan->where('status', 'berhasil');
        });

        $jumlahPemesananPending = $user->lapangan->flatMap(function ($lap) {
            return $lap->pemesanan->where('status', 'pending');
        })->count();

        $totalSaldo = $jumlahPemesananBerhasil->sum('total_harga') - $jumlahPenarikan;

        return view('penyedia_lapangan.dashboard', [
            'totalSaldo' => $totalSaldo,
            'dataLapangan' => $user->lapangan,
            'dataPenarikan' => $user->penarikan,
            'pemesananPending' => $jumlahPemesananPending,
            'pemesananBerhasil' => $jumlahPemesananBerhasil->count(),
        ]);
    }

}
