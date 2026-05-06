<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with([
            'user',
            'detail.barang',
            'kerusakan',
            'keterlambatan',
            'hilang'
        ]);

        // FILTER TANGGAL
        if($request->dari && $request->sampai){
            $query->whereBetween('tanggal_pinjam', [$request->dari, $request->sampai]);
        }

        $data = $query->latest()->get();

        // ================= TOTAL =================
        $total_sewa = $data->sum('total_harga');

        $total_denda = 
            $data->sum(function($t){
                return 
                    $t->kerusakan->sum('total_denda') +
                    $t->keterlambatan->sum('total_denda') +
                    $t->hilang->sum('denda');
            });

        $grand_total = $total_sewa + $total_denda;

        return view('laporan.index', compact(
            'data',
            'total_sewa',
            'total_denda',
            'grand_total'
        ));
    }
}