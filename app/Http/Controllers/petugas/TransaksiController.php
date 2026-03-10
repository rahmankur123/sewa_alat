<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransaksiMail;
use App\Models\Kerusakan;
use App\Models\Keterlambatan;
use DB;

class TransaksiController extends Controller
{
    // LIST TRANSAKSI
    public function index()
    {
        $transaksi = Transaksi::latest()->paginate(10);
        return view('petugas.transaksi.index', compact('transaksi'));
    }

    // FORM CREATE
    public function create()
    {
        $barang = Barang::all();
        $users = User::where('role','anggota')->where('status','aktif')->get();
        return view('petugas.transaksi.create', compact('barang','users'));
    }

    //FORM DETAIL
    public function show($id)
    {
        $transaksi = Transaksi::with('user','detailTransaksi.barang')->findOrFail($id);
        return view('petugas.transaksi.show', compact('transaksi'));
    }

    //FORM NOTA
    public function nota($id)
    {
        $transaksi = Transaksi::with('user','detailTransaksi.barang')->findOrFail($id);
        return view('petugas.transaksi.nota', compact('transaksi'));
    }

    // SIMPAN TRANSAKSI
   public function store(Request $request)
{
    $transaksi = DB::transaction(function() use ($request){

        // ================== HANDLE USER ==================
        if($request->user_id){

            $user = User::findOrFail($request->user_id);

        } else {

            $user = User::create([
                'name' => 'User Baru',
                'email' => $request->email,
                'password' => Hash::make(Str::random(8)),
                'role' => 'anggota',
                'status' => 'belum_aktif',
                'alamat' => '-',
                'token_aktivasi' => Str::random(40)
            ]);
        }

        // ================== BUAT TRANSAKSI ==================
        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'total_harga' => 0,
            'status_pembayaran' => 'lunas',
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

        // ================== KIRIM EMAIL ==================

        $isBaru = $user->status === 'belum_aktif';

        Mail::to($user->email)
            ->send(new TransaksiMail($transaksi, $user, $isBaru));

        return $transaksi;
    });

    return redirect()
            ->route('petugas.transaksi.show', $transaksi->id)
            ->with('success','Transaksi berhasil');
}
public function dipinjam()
{
    $data = Transaksi::with('user')
            ->where('status_transaksi','dipinjam')
            ->get();

    return view('petugas.transaksi.dipinjam', compact('data'));
}

public function formKembalikan($id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    return view('petugas.transaksi.kembalikan', compact('transaksi'));
}


public function prosesKembalikan(Request $request,$id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    $tanggal_real = $request->tanggal_kembali_real;
    $tanggal_rencana = $transaksi->tanggal_kembali_rencana;

    $total_denda = 0;

    // cek keterlambatan
if($tanggal_real > $tanggal_rencana){

    $hari_telat = \Carbon\Carbon::parse($tanggal_rencana)
                    ->diffInDays($tanggal_real);

    foreach($transaksi->detail as $detail){

        $barang = $detail->barang;

        $denda_telat = $hari_telat * $barang->denda_keterlambatan_per_hari * $detail->qty;

        $total_denda += $denda_telat;

        Keterlambatan::create([
            'transaksi_id' => $transaksi->id,
            'barang_id' => $barang->id,
            'qty' => $detail->qty,
            'total_denda' => $denda_telat,
            'durasi_hari' => \Carbon\Carbon::parse($transaksi->tanggal_pinjam)
                            ->diffInDays($tanggal_real)
        ]);
    }
}

    // cek kerusakan
    if($request->rusak){
    foreach($request->rusak as $barang_id => $data){

        $qty_rusak = count($data); // hitung jumlah rusak

        if($qty_rusak > 0){

            $barang = Barang::find($barang_id);

            $denda = $barang->denda_kerusakan * $qty_rusak;

            $total_denda += $denda;

            Kerusakan::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barang_id,
                'qty' => $qty_rusak,
                'total_denda' => $denda
            ]);
        }
    }
}
// kembalikan stok
foreach($transaksi->detail as $detail){

    $barang = $detail->barang;

    // kembalikan stok
    $barang->increment('stok', $detail->qty);
}
    // update transaksi
    $transaksi->tanggal_kembali_real = $tanggal_real;
    $transaksi->total_denda = $total_denda;

    if($total_denda > 0){
        $transaksi->status_transaksi = 'terdenda';
    }else{
        $transaksi->status_transaksi = 'selesai';
    }

    $transaksi->save();

    return redirect()->route('transaksi.dipinjam')
        ->with('success','Pengembalian berhasil');
}
public function terdenda()
{
    $data = Transaksi::with([
        'user',
        'kerusakan',
        'keterlambatan'
    ])
    ->where('status_transaksi','terdenda')
    ->get();

    return view('petugas.transaksi.terdenda', compact('data'));
}
public function lunas($id)
{
    $transaksi = Transaksi::with('user','kerusakan.barang')->findOrFail($id);

    $transaksi->update([
        'status_pembayaran' => 'lunas',
        'status_transaksi' => 'selesai'
    ]);

    return view('petugas.transaksi.nota_denda', compact('transaksi'));
}
public function selesai()
{
   $data = Transaksi::with(['user','kerusakan','keterlambatan'])
        ->where('status_transaksi','selesai')
        ->get();

    return view('petugas.transaksi.selesai', compact('data'));

}

public function notaSelesai($id)
{
    $transaksi = Transaksi::with([
        'user',
        'detail.barang',
        'kerusakan.barang',
        'keterlambatan'
    ])->findOrFail($id);

    return view('petugas.transaksi.nota_selesai', compact('transaksi'));
}
public function tersewa()
{
    $data = Transaksi::with(['user'])
        ->where('status_transaksi','tersewa')
        ->get();

    return view('petugas.transaksi.tersewa', compact('data'));
}

public function diambil($id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    // ubah status
    $transaksi->update([
        'status_transaksi' => 'dipinjam'
    ]);

    // kurangi stok barang
    foreach($transaksi->detail as $detail){

        $detail->barang->decrement('stok', $detail->qty);

    }

    return redirect()->route('transaksi.tersewa')
        ->with('success','Status transaksi diupdate & stok berkurang');
}
}
