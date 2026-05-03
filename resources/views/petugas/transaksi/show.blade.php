@extends('layouts.app')

@section('title','Detail Transaksi')

@section('content')

<style>
/* ================= PRINT MODE ================= */
@media print {

    body * {
        visibility: hidden;
    }

    .print-area, .print-area * {
        visibility: visible;
    }

    .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table th, table td {
        border: 1px solid #000;
        padding: 6px;
    }
}
</style>

<h2 class="text-2xl font-semibold text-slate-700 mb-6 no-print">
    Detail Transaksi
</h2>

{{-- BUTTON --}}
<div class="flex max-w-4xl mx-auto justify-start gap-3 mb-4 no-print">

    <a href="{{ url()->previous() }}"
       class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800 transition">
        ← Kembali
    </a>

    <a href="{{ route('petugas.transaksi.create') }}"
       class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600">
        Transaksi Baru
    </a>

    <a href="{{ route('petugas.transaksi.tersewa') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Lihat Data Tersewa
    </a>

    <button onclick="window.print()"
       class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
        🖨️ Cetak Nota
    </button>
</div>

{{-- ================= AREA PRINT ================= --}}
<div class="print-area max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">

    {{-- HEADER --}}
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">NOTA SEWA</h2>
        <p class="text-sm text-slate-500">Sistem Persewaan Alat Bela Diri</p>
    </div>

    {{-- INFO --}}
    <div class="grid grid-cols-2 gap-4 text-sm mb-6">

        <div>
            <p class="text-slate-500">No Transaksi</p>
            <p class="font-medium">#{{ $transaksi->id }}</p>
        </div>

        <div>
            <p class="text-slate-500">Nama Penyewa</p>
            <p class="font-medium">{{ $transaksi->user->name }}</p>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Pinjam</p>
            <p>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Rencana Kembali</p>
            <p>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
            </p>
        </div>

    </div>

    {{-- TABEL --}}
    <table class="w-full text-sm mb-6 border border-slate-200">

        <thead class="bg-slate-100 text-slate-600 text-xs uppercase">
            <tr>
                <th class="p-2 text-left">No</th>
                <th class="p-2 text-left">Barang</th>
                <th class="p-2 text-center">Qty</th>
                <th class="p-2 text-right">Harga</th>
                <th class="p-2 text-right">Subtotal</th>
            </tr>
        </thead>

        <tbody>

        @php $total = 0; @endphp

        @foreach($transaksi->detail as $i => $d)

            @php
                $subtotal = $d->qty * $d->harga_per_hari;
                $total += $subtotal;
            @endphp

            <tr>
                <td class="p-2">{{ $i + 1 }}</td>
                <td class="p-2">{{ $d->barang->nama_barang }}</td>
                <td class="p-2 text-center">{{ $d->qty }}</td>
                <td class="p-2 text-right">Rp {{ number_format($d->harga_per_hari,0,',','.') }}</td>
                <td class="p-2 text-right">Rp {{ number_format($subtotal,0,',','.') }}</td>
            </tr>

        @endforeach

        <tr class="font-semibold">
            <td colspan="4" class="p-2 text-right">Total</td>
            <td class="p-2 text-right">
                Rp {{ number_format($total,0,',','.') }}
            </td>
        </tr>

        </tbody>
    </table>

    {{-- TTD --}}
    <div class="mt-10 text-right text-sm">
        <p>Petugas</p>
        <br><br><br>
        <p>____________________</p>
    </div>

</div>

@endsection