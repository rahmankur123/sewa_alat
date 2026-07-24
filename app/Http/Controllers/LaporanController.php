<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    private function filterTanggal($query, Request $request, $column = 'created_at')
    {
        if ($request->filled('tanggal_awal')) {
            $query->whereDate($column, '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate($column, '<=', $request->tanggal_akhir);
        }

        return $query;
    }

    public function barangHilang(Request $request)
    {
        $data = Transaksi::with(['user','hilang.barang'])
            ->whereHas('hilang');

        $this->filterTanggal($data, $request, 'tanggal_pinjam');
        $data = $data->latest()->paginate(10)->withQueryString();

        return view('laporan.barang_hilang', compact('data'));
    }

    public function kerusakan(Request $request)
    {
        $data = Transaksi::with(['user','kerusakan.barang'])
            ->whereHas('kerusakan');

        $this->filterTanggal($data, $request, 'tanggal_pinjam');

        $data = $data->latest()->paginate(10)->withQueryString();

        return view('laporan.kerusakan', compact('data'));
    }

    public function penyewaan(Request $request)
    {
        $query = Transaksi::with([
            'user',
            'detail.barang',
            'keterlambatan',
            'kerusakan',
            'hilang'
        ]);

        // FILTER TANGGAL
        if ($request->tanggal_awal && $request->tanggal_akhir) {

            $query->whereBetween('created_at', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // FILTER STATUS
        if ($request->status) {

            $query->where('status_transaksi', $request->status);
        }

        $data = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('laporan.penyewaan', compact('data'));
    }

    public function barangHilangPdf(Request $request)
    {
        $data = $this->barangHilangData($request);
        return Pdf::loadView('laporan.pdf_barang_hilang', compact('data'))
            ->download('laporan_barang_hilang.pdf');
    }

    public function kerusakanPdf(Request $request)
    {
        $data = $this->kerusakanData($request);
        return Pdf::loadView('laporan.pdf_kerusakan', compact('data'))
            ->download('laporan_kerusakan.pdf');
    }

    public function penyewaanPdf(Request $request)
    {
        $data = $this->penyewaanData($request);
        return Pdf::loadView('laporan.pdf_penyewaan', compact('data'))
            ->download('laporan_penyewaan.pdf');
    }

    private function barangHilangData(Request $request)
    {
        $q = Transaksi::with(['user','hilang.barang'])->whereHas('hilang');
        $this->filterTanggal($q, $request, 'tanggal_pinjam');
        return $q->latest()->get();
    }

    private function kerusakanData(Request $request)
    {
        $q = Transaksi::with(['user','kerusakan.barang'])->whereHas('kerusakan');
        $this->filterTanggal($q, $request, 'tanggal_pinjam');
        return $q->latest()->get();
    }

    private function penyewaanData(Request $request)
    {
        if ($request->status) {
            $q = Transaksi::with([
                'user','detail.barang','keterlambatan','kerusakan.barang','hilang.barang'
            ])->where('status_transaksi', $request->status);
        } else {
        $q = Transaksi::with([
            'user','detail.barang','keterlambatan','kerusakan.barang','hilang.barang'
        ]);
        }
        $this->filterTanggal($q, $request, 'tanggal_pinjam');
        return $q->latest()->get();
    }
}
