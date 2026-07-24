<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ================= ADMIN & PETUGAS =================
    public function admin()
    {
        $total_barang = Barang::count();
        $total_transaksi = Transaksi::count();

        $dipinjam = Transaksi::where('status_transaksi', 'dipinjam')->count();
        $terdenda = Transaksi::where('status_transaksi', 'terdenda')->count();

        // Jika kolom total_denda belum ada, gunakan 0 agar tidak error
        $total_denda = Transaksi::sum('total_denda') ?? 0;

        $total_anggota = User::where('role','anggota')->count();

        $pendapatan_bulan_ini = Transaksi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_harga');

        $transaksi_hari_ini = Transaksi::whereDate('created_at', today())->count();

        $total_pendapatan = Transaksi::sum('total_harga');

        $sedang_berjalan = Transaksi::whereIn('status_transaksi', [
            'dipinjam',
            'tersewa'
        ])->count();

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
            'total_anggota',
            'pendapatan_bulan_ini',
            'transaksi_hari_ini',
            'total_pendapatan',
            'sedang_berjalan',
            'latest'
        ));
    }

    // ================= ANGGOTA =================
    public function anggota()
    {
        $user = Auth::user();

        // Total seluruh transaksi sewa user
        $total = Transaksi::where('user_id', $user->id)->count();

        // Sedang dipinjam
        $dipinjam = Transaksi::where('user_id', $user->id)
            ->where('status_transaksi', 'dipinjam')
            ->count();

        // Transaksi yang memiliki denda
        $terdenda = Transaksi::where('user_id', $user->id)
            ->where('status_transaksi', 'terdenda')
            ->count();

        // Riwayat terbaru
        $latest = Transaksi::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.anggota', compact(
            'total',
            'dipinjam',
            'terdenda',
            'latest'
        ));
    }
}