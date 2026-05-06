@extends('layouts.app')

@section('title','Nota Denda')

@section('content')

{{-- BUTTON --}}
<div class="no-print mb-4 flex justify-between max-w-4xl mx-auto">

    <a href="{{ url()->previous() }}"
       class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800">
        ← Kembali
    </a>

    <button onclick="window.print()"
        class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">
        🖨️ Cetak Nota
    </button>

</div>

{{-- NOTA --}}
<div class="print-area max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">

    {{-- HEADER --}}
    <div class="flex justify-between items-center border-b pb-4 mb-6">

        <div>
            <h2 class="text-xl font-bold text-slate-800">NOTA DENDA</h2>
            <p class="text-sm text-slate-500">Sistem Persewaan Alat Bela Diri</p>
        </div>

        <div class="text-right text-sm">
            <p>No Nota:</p>
            <p class="font-semibold">
                INV-DENDA-{{ date('Ymd') }}-{{ $transaksi->id }}
            </p>
            <p class="text-slate-500">
                {{ now()->translatedFormat('d F Y') }}
            </p>
        </div>

    </div>

    {{-- INFO --}}
    <div class="grid grid-cols-2 gap-6 text-sm mb-6">

        <div>
            <p class="text-slate-500">Nama Penyewa</p>
            <p class="font-medium">{{ $transaksi->user->name }}</p>
        </div>

        <div>
            <p class="text-slate-500">Status</p>
            <p class="font-medium capitalize">
                {{ $transaksi->status_transaksi }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Pinjam</p>
            <p>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Kembali</p>
            <p>
                {{ $transaksi->tanggal_kembali_real 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

    </div>

    {{-- ================= HITUNG TOTAL ================= --}}
    @php
        $total_keterlambatan = $transaksi->keterlambatan->sum('total_denda');
        $total_kerusakan     = $transaksi->kerusakan->sum('total_denda');
        $total_hilang        = $transaksi->barangHilang->sum('denda');

        $total_denda = $total_keterlambatan + $total_kerusakan + $total_hilang;
    @endphp

    {{-- KETERLAMBATAN --}}
    <h3 class="font-semibold text-slate-700 mb-2">Denda Keterlambatan</h3>

    @if($transaksi->keterlambatan->count())
        <table class="w-full text-sm border mb-6">
            <thead class="bg-slate-100 text-xs uppercase">
                <tr>
                    <th class="p-2 border text-left">Durasi</th>
                    <th class="p-2 border text-right">Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->keterlambatan as $k)
                <tr>
                    <td class="p-2 border">{{ $k->durasi_hari }} hari</td>
                    <td class="p-2 border text-right text-red-500">
                        Rp {{ number_format($k->total_denda,0,',','.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mb-6 text-slate-400">Tidak ada keterlambatan</p>
    @endif


    {{-- KERUSAKAN --}}
    <h3 class="font-semibold text-slate-700 mb-2">Denda Kerusakan</h3>

    @if($transaksi->kerusakan->count())
        <table class="w-full text-sm border mb-6">
            <thead class="bg-slate-100 text-xs uppercase">
                <tr>
                    <th class="p-2 border text-left">Barang</th>
                    <th class="p-2 border text-center">Qty</th>
                    <th class="p-2 border text-right">Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->kerusakan as $k)
                <tr>
                    <td class="p-2 border">{{ $k->barang->nama_barang }}</td>
                    <td class="p-2 border text-center">{{ $k->qty }}</td>
                    <td class="p-2 border text-right text-red-500">
                        Rp {{ number_format($k->total_denda,0,',','.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mb-6 text-slate-400">Tidak ada kerusakan</p>
    @endif


    {{-- BARANG HILANG --}}
    <h3 class="font-semibold text-slate-700 mb-2">Denda Barang Hilang</h3>

    @if($transaksi->barangHilang->count())
        <table class="w-full text-sm border mb-6">
            <thead class="bg-slate-100 text-xs uppercase">
                <tr>
                    <th class="p-2 border text-left">Barang</th>
                    <th class="p-2 border text-center">Qty</th>
                    <th class="p-2 border text-right">Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->barangHilang as $h)
                <tr>
                    <td class="p-2 border">{{ $h->barang->nama_barang }}</td>
                    <td class="p-2 border text-center">{{ $h->qty }}</td>
                    <td class="p-2 border text-right text-red-500">
                        Rp {{ number_format($h->denda,0,',','.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mb-6 text-slate-400">Tidak ada barang hilang</p>
    @endif


    {{-- TOTAL --}}
    <div class="bg-slate-50 border rounded-lg p-4 text-sm space-y-2">

        <div class="flex justify-between">
            <span>Denda Keterlambatan</span>
            <span class="text-red-500">
                Rp {{ number_format($total_keterlambatan,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between">
            <span>Denda Kerusakan</span>
            <span class="text-red-500">
                Rp {{ number_format($total_kerusakan,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between">
            <span>Denda Barang Hilang</span>
            <span class="text-red-500">
                Rp {{ number_format($total_hilang,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between font-bold text-lg border-t pt-2">
            <span>Total Denda</span>
            <span class="text-red-600">
                Rp {{ number_format($total_denda,0,',','.') }}
            </span>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="mt-10 flex justify-between text-sm">

        <div>
            <p class="text-slate-500">Catatan:</p>
            <p class="text-slate-400">Harap segera melakukan pembayaran denda 🙏</p>
        </div>

        <div class="text-right">
            <p class="text-slate-600">Petugas</p>
            <br><br><br>
            <p class="border-t inline-block px-4 pt-1">
                {{ auth()->user()->name ?? 'Admin' }}
            </p>
        </div>

    </div>

</div>

@endsection