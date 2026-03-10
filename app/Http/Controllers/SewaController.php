<?php 

namespace App\Http\Controllers\Anggota;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{

// LIST BARANG YANG BISA DISEWA
public function index()
{
    $barang = Barang::where('stok','>',0)->get();

    return view('anggota.sewa', compact('barang'));
}


// RIWAYAT SEWA USER
public function riwayat()
{
    $data = Transaksi::with('detail.barang')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('anggota.riwayat', compact('data'));
}


// PROFIL USER
public function profil()
{
    $user = Auth::user();

    return view('anggota.profil', compact('user'));
}

}