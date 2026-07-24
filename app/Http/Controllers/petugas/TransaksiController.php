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
use App\Models\BarangHilang;
use DB;
use Carbon\Carbon;

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
        $barang = Barang::where('stok', '>', 0)->get();
        $users = User::where('role','anggota')->get();
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
    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali_rencana' => 'required|date',
        'barang_id' => 'required|array',
        'qty' => 'required|array',
    ]);

    $transaksi = DB::transaction(function() use ($request){

        // ================== HANDLE USER ==================
        
          $user = User::findOrFail($request->user_id);
        // ================== HITUNG DURASI ==================
        $durasi = $request->durasi 
            ?? \Carbon\Carbon::parse($request->tanggal_pinjam)
                ->diffInDays($request->tanggal_kembali_rencana);

        if ($durasi <= 0) $durasi = 1;

        // ================== BUAT TRANSAKSI ==================
        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'total_harga' => 0,
            'status_pembayaran' => 'lunas',
            'status_transaksi' => 'dipinjam', // 🔥 penting
        ]);

        $total = 0;

        foreach($request->barang_id as $i => $id){

            // skip kalau kosong
            if (!$id || !$request->qty[$i]) continue;

            $barang = Barang::findOrFail($id);
            $qty = (int) $request->qty[$i];

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

        // ================== UPDATE TOTAL ==================
        $transaksi->update([
            'total_harga' => $total
        ]);

        // ================== LOAD RELASI (BIAR LANGSUNG KE VIEW) ==================
        $transaksi->load(['user','detail.barang']);
        return $transaksi;
    });

    return redirect()
        ->route('petugas.transaksi.show', $transaksi->id)
        ->with('success','Transaksi berhasil dibuat');
}
public function dipinjam(Request $request)
{
    $query = Transaksi::with('user')
        ->where('status_transaksi', 'dipinjam');

    if ($request->search) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $data = $query->latest()->paginate(10)->withQueryString();

    return view('petugas.transaksi.dipinjam', compact('data'));
}

public function formKembalikan($id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    return view('petugas.transaksi.kembalikan', compact('transaksi'));
}


public function prosesKembalikan(Request $request, $id)
{
    $transaksi = Transaksi::with('detail.barang')->findOrFail($id);

    $request->validate([
        'tanggal_kembali_real' => 'required|date',
    ]);

    DB::beginTransaction();

    try {
        // ==============================
        // UPDATE TANGGAL KEMBALI
        // ==============================
        $transaksi->tanggal_kembali_real = $request->tanggal_kembali_real;
        $transaksi->save();

        // ==============================
        // HAPUS DATA LAMA (jika edit)
        // ==============================
        Kerusakan::where('transaksi_id', $transaksi->id)->delete();
        BarangHilang::where('transaksi_id', $transaksi->id)->delete();

        // ==============================
        // PROSES KERUSAKAN
        // ==============================
        $totalRusakPerBarang = [];

        if ($request->has('rusak')) {
            foreach ($request->rusak as $barangId => $items) {

                foreach ($items as $jenis) {
                    if (!$jenis) {
                continue;
            }

                    $barang = Barang::findOrFail($barangId);

                    // Ringan = harga_kerusakan
                    // Berat = harga barang (ganti penuh)
                    $denda = $jenis === 'berat'
                        ? $barang->denda_hilang
                        : $barang->denda_kerusakan;

                    Kerusakan::create([
                        'transaksi_id'    => $transaksi->id,
                        'barang_id'       => $barangId,
                        'qty'          => 1,
                        'jenis_kerusakan' => $jenis,
                        'total_denda'     => $denda,
                    ]);

                    if (!isset($totalRusakPerBarang[$barangId])) {
                        $totalRusakPerBarang[$barangId] = 0;
                    }

                    $totalRusakPerBarang[$barangId]++;
                }
            }
        }

        // ==============================
        // PROSES BARANG HILANG
        // ==============================
        if ($request->has('hilang')) {
            foreach ($request->hilang as $barangId => $qty) {

                $qty = (int) $qty;

                if ($qty <= 0) {
                    continue;
                }

                // Cari qty yang dipinjam
                $detail = $transaksi->detail
                    ->where('barang_id', $barangId)
                    ->first();

                if (!$detail) {
                    continue;
                }

                $qtyDipinjam = $detail->qty;
                $qtyRusak = $totalRusakPerBarang[$barangId] ?? 0;
                $maksHilang = $qtyDipinjam - $qtyRusak;

                // Validasi agar tidak melebihi sisa unit
                if ($qty > $maksHilang) {
                    throw new \Exception(
                        "Jumlah barang hilang untuk {$detail->barang->nama_barang} melebihi batas maksimal {$maksHilang} unit."
                    );
                }

                $barang = Barang::findOrFail($barangId);

                BarangHilang::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $barangId,
                    'qty'          => $qty,
                    'denda'        => ($barang->denda_hilang ?? 0) * $qty,
                ]);
            }
        }

        // ==============================
        // PROSES DENDA KETERLAMBATAN
        // ==============================
        if (
            $transaksi->tanggal_kembali_real >
            $transaksi->tanggal_kembali_rencana
        ) {
            $hari = Carbon::parse(
    $transaksi->tanggal_kembali_rencana
)->diffInDays(
    Carbon::parse(
        $transaksi->tanggal_kembali_real
    )
);
 // Ambil barang pertama dari transaksi
$barangPertama = $transaksi->detail->first();

$dendaPerHari = 0;

if ($barangPertama && $barangPertama->barang) {
    $dendaPerHari = $barangPertama->barang->denda_keterlambatan_per_hari;
}

Keterlambatan::create([
    'transaksi_id' => $transaksi->id,
    'barang_id'    => $barangPertama?->barang_id,
    'qty'          => 1,
    'durasi_hari'  => $hari,
    'total_denda'  => $hari * $dendaPerHari,
]);
        }

        // ==============================
        // UPDATE STATUS
        // ==============================
        $adaKerusakan = Kerusakan::where('transaksi_id', $transaksi->id)->exists();
        $adaHilang = BarangHilang::where('transaksi_id', $transaksi->id)->exists();
        $adaTerlambat = Keterlambatan::where('transaksi_id', $transaksi->id)->exists();

        if ($adaKerusakan || $adaHilang || $adaTerlambat) {
            $transaksi->status_transaksi = 'terdenda';
        } else {
            $transaksi->status_transaksi = 'selesai';
        }

        $transaksi->save();

        DB::commit();

        return redirect()
            ->route('petugas.transaksi.dipinjam')
            ->with('success', 'Pengembalian berhasil diproses.');
    } catch (\Exception $e) {
        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

public function detail($id)
{
    $transaksi = Transaksi::with('user','detail.barang')
            ->findOrFail($id);

    return view('petugas.transaksi.detail', compact('transaksi'));
}

public function terdenda(Request $request)
{
    $query = Transaksi::with(['user','kerusakan','keterlambatan'])
        ->where('status_transaksi','terdenda');

    if ($request->search) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $data = $query->latest()->paginate(10)->withQueryString();
    return view('petugas.transaksi.terdenda', compact('data'));
}

public function notaDenda($id)
{
    $transaksi = Transaksi::with([
        'user',
        'detail.barang',
        'kerusakan.barang',
        'keterlambatan'
    ])->findOrFail($id);

    return view('petugas.transaksi.nota_denda', compact('transaksi'));
}
public function lunas($id)
{
    $transaksi = Transaksi::with('user','kerusakan.barang')->findOrFail($id);

    $transaksi->update([
        'status_pembayaran' => 'lunas',
        'status_transaksi' => 'selesai'
    ]);

    $data = Transaksi::with([
        'user',
        'kerusakan',
        'keterlambatan'
    ])
    ->where('status_transaksi','terdenda')
    ->paginate(10);
    return view('petugas.transaksi.terdenda', compact('data'));
}

public function selesai(Request $request)
{
    $query = Transaksi::with('user')
        ->where('status_transaksi','selesai');

    if ($request->search) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $data = $query->latest()->paginate(10)->withQueryString();

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

public function barangHilang(Request $request)
{
    $query = BarangHilang::with(['transaksi.user','barang']);

    if ($request->search) {
        $query->whereHas('transaksi.user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }
    $data = $query->latest()->paginate(10)->withQueryString();
    return view('petugas.transaksi.hilang', compact('data'));
}
public function tersewa(Request $request)
{
    $query = Transaksi::with(['user'])
        ->where('status_transaksi','tersewa');
    
    // SEARCH NAMA USER
    if ($request->search) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $data = $query->latest()->paginate(10);

    return view('petugas.transaksi.tersewa', compact('data'));
}

public function ProsesAmbil($id)
{
    $transaksi = Transaksi::with([
        'user',
        'detail.barang'
    ])->findOrFail($id);

    $barang = Barang::all();

    return view(
        'petugas.transaksi.pengambilan',
        compact('transaksi','barang')
    );
}

public function diambil(Request $request, $id)
{
    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali_rencana' => 'required|date',
        'barang_id' => 'required|array',
        'qty' => 'required|array',
    ]);

    DB::beginTransaction();

    try{

        $transaksi = Transaksi::with('detail.barang')
            ->findOrFail($id);

        // ==========================
        // Kembalikan stok lama
        // ==========================

        foreach($transaksi->detail as $detail){

            $detail->barang->increment('stok',$detail->qty);

        }

        // ==========================
        // Hapus detail lama
        // ==========================

        $transaksi->detail()->delete();

        // ==========================
        // Update tanggal
        // ==========================

        $transaksi->tanggal_pinjam = $request->tanggal_pinjam;

        $transaksi->tanggal_kembali_rencana =
            $request->tanggal_kembali_rencana;

        $transaksi->total_harga = 0;

        $transaksi->save();

        // ==========================
        // Hitung durasi
        // ==========================

        $durasi = Carbon::parse($request->tanggal_pinjam)
            ->diffInDays($request->tanggal_kembali_rencana);

        if($durasi <= 0){
            $durasi = 1;
        }

        $total = 0;

        // ==========================
        // Simpan detail baru
        // ==========================

        foreach($request->barang_id as $i=>$barangId){

            $barang = Barang::findOrFail($barangId);

            $qty = (int)$request->qty[$i];

            $subtotal =
                $barang->harga_per_hari *
                $qty *
                $durasi;

            DetailTransaksi::create([

                'transaksi_id'=>$transaksi->id,

                'barang_id'=>$barangId,

                'qty'=>$qty,

                'harga_per_hari'=>$barang->harga_per_hari,

                'subtotal'=>$subtotal

            ]);

            $barang->decrement('stok',$qty);

            $total += $subtotal;

        }

        // ==========================
        // Update transaksi
        // ==========================

        $transaksi->update([

            'total_harga'=>$total,

            'status_transaksi'=>'dipinjam'

        ]);

        DB::commit();

        return redirect()
            ->route('petugas.transaksi.dipinjam')
            ->with('success',
                'Barang berhasil diserahkan kepada penyewa.');

    }catch(\Exception $e){

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error',$e->getMessage());

    }
}

public function hapus($id)
{
    $transaksi = Transaksi::findOrFail($id);

    // kembalikan stok jika sedang dipinjam
    if(in_array($transaksi->status_transaksi, ['dipinjam','tersewa'])){

        foreach($transaksi->detail as $detail){
            $detail->barang->increment('stok', $detail->qty);
        }
    }

    // 🔥 hapus relasi dulu
    $transaksi->detail()->delete();
    $transaksi->kerusakan()->delete();
    $transaksi->keterlambatan()->delete();
    $transaksi->barangHilang()->delete();

    $transaksi->delete();

    return redirect()->back()->with('success','Transaksi berhasil dihapus');
}

public function detailSelesai($id)
{
    $transaksi = Transaksi::with('user','detail.barang','kerusakan.barang','keterlambatan')->findOrFail($id);

    return view('petugas.transaksi.detailselesai', compact('transaksi'));
}
public function detailDenda($id)
{
    $transaksi = Transaksi::with('user','detail.barang','kerusakan.barang','keterlambatan')->findOrFail($id);  

    return view('petugas.transaksi.detaildenda', compact('transaksi'));
}

}
