<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ================= ADMIN & PETUGAS =================
    public function admin()
    {
        $total_barang = Barang::count();
        $total_transaksi = Transaksi::count();

        $dipinjam = Transaksi::where('status_transaksi','dipinjam')->count();
        $terdenda = Transaksi::where('status_transaksi','terdenda')->count();

        $total_denda = Transaksi::sum('total_denda');

        $latest = Transaksi::with('user')
                    ->latest()
                    ->limit(5)
                    ->get();

        return view('dashboard.admin', compact(
            'total_barang',
            'total_transaksi',
            'dipinjam',
            'terdenda',
            'total_denda',
            'latest'
        ));
    }
 
    // ================= ANGGOTA =================
    public function anggota()
    {
        $user = Auth::user();

        $total_sewa = Transaksi::where('user_id',$user->id)->count();

        $dipinjam = Transaksi::where('user_id',$user->id)
                    ->where('status_transaksi','dipinjam')->count();

        $terdenda = Transaksi::where('user_id',$user->id)
                    ->where('status_transaksi','terdenda')->count();

        $latest = Transaksi::where('user_id',$user->id)
                    ->latest()
                    ->limit(5)
                    ->get();

        return view('dashboard.anggota', compact(
            'total_sewa',
            'dipinjam',
            'terdenda',
            'latest'
        ));
    }
}