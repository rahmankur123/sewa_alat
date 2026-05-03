<?php 

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{

// TRANSAKSI SEWA
public function store(Request $request)
{
    $transaksi = Transaksi::create([
        'user_id' => Auth::id(),
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
        'status_transaksi' => 'tersewa',
        'status_pembayaran' => 'belum_bayar',
        'total_harga' => 0
    ]);

    $durasi = $request->durasi ?? 1;
    $total = 0;

    foreach($request->barang_id as $i => $id){

            $barang = Barang::findOrFail($id);
            $qty = $request->qty[$i];
            $subtotal = $barang->harga_per_hari * $qty * $durasi;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $id,
                'qty' => $qty,
                'harga_per_hari' => $barang->harga_per_hari,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;
        }

        $transaksi->update(['total_harga'=>$total]);

    return redirect()->route('riwayat.tersewa')
        ->with('success','Sewa berhasil');
}

// LIST BARANG YANG BISA DISEWA
public function index()
{
    $barang = Barang::where('stok','>',0)->get();
    return view('anggota.sewa', compact('barang'));
}


// PROFIL USER
public function profil()
{
    $user = Auth::user();

    return view('anggota.profil', compact('user'));
}

public function editProfil(Request $request)
{
    
}

public function tersewa()
{
    $user = Auth::user();

    $data = Transaksi::with('detail.barang')
            ->where('user_id', $user->id)
            ->whereIn('status_transaksi',['tersewa'])
            ->paginate(10);

    return view('anggota.riwayat.tersewa', compact('data'));
}

public function dipinjam()
{ 
    $user = Auth::user();

    $data = Transaksi::with('detail.barang')
            ->where('user_id', $user->id)
            ->whereIn('status_transaksi',['dipinjam'])
            ->paginate(10);

    return view('anggota.riwayat.dipinjam', compact('data'));
}

public function terdenda()
{
    $user = Auth::user();

    $data = Transaksi::with('detail.barang')
            ->where('user_id', $user->id)
            ->whereIn('status_transaksi',['terdenda'])
            ->paginate(10);

    return view('anggota.riwayat.terdenda', compact('data'));
}
public function selesai()
{
    $user = Auth::user();

    $data = Transaksi::with('detail.barang')
            ->where('user_id', $user->id)
            ->whereIn('status_transaksi',['selesai'])
            ->paginate(10);

    return view('anggota.riwayat.selesai', compact('data'));
}

public function detail($id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    return view('anggota.riwayat.detail', compact('transaksi'));
}
public function detailDenda($id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    return view('anggota.riwayat.detaildenda', compact('transaksi'));
}
public function detailSelesai($id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    return view('anggota.riwayat.detailselesai', compact('transaksi'));
}

}