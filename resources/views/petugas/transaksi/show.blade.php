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
<div class="flex flex-wrap max-w-4xl mx-auto gap-3 mb-4 no-print">

    <a href="{{ route('petugas.transaksi.create') }}"
       class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600">
        + Transaksi Baru
    </a>

    <a href="{{ route('petugas.transaksi.dipinjam') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Data Dipinjam
    </a>

    <button onclick="window.print()"
       class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
        🖨️ Cetak Nota
    </button>
</div>

{{-- ================= AREA PRINT ================= --}}
<div class="print-area max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">

    {{-- HEADER --}}
    <div class="flex justify-between items-center border-b pb-4 mb-6">

        <div>
            <h2 class="text-xl font-bold text-slate-800">NOTA SEWA</h2>
            <p class="text-sm text-slate-500">Sistem Persewaan Alat Bela Diri</p>
        </div>

        <div class="text-right text-sm">
            <p>No Nota:</p>
            <p class="font-semibold">
                INV-SEWA-{{ date('Ymd') }}-{{ $transaksi->id }}
            </p>
            <p class="text-slate-500">
                {{ now()->translatedFormat('d F Y') }}
            </p>
        </div>

    </div>

    {{-- INFO --}}
    <div class="grid grid-cols-2 gap-4 text-sm mb-6">

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
            <p class="text-slate-500">Rencana Kembali</p>
            <p>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
            </p>
        </div>

    </div>

    {{-- TABEL BARANG --}}
    <div class="overflow-x-auto mb-6">
        <table class="w-full text-sm border border-slate-200">

            <thead class="bg-slate-100 text-slate-600 text-xs uppercase">
                <tr>
                    <th class="p-2 text-left">Barang</th>
                    <th class="p-2 text-center">Qty</th>
                    <th class="p-2 text-right">Harga / Hari</th>
                    <th class="p-2 text-right">Subtotal</th>
                </tr>
            </thead>

            <tbody>

            @php $total_sewa = 0; @endphp

            @foreach($transaksi->detail as $d)

                @php
                    $subtotal = $d->subtotal; // pakai dari DB
                    $total_sewa += $subtotal;
                @endphp

                <tr class="border-t">
                    <td class="p-2">{{ $d->barang->nama_barang }}</td>
                    <td class="p-2 text-center">{{ $d->qty }}</td>
                    <td class="p-2 text-right">
                        Rp {{ number_format($d->harga_per_hari,0,',','.') }}
                    </td>
                    <td class="p-2 text-right font-medium">
                        Rp {{ number_format($subtotal,0,',','.') }}
                    </td>
                </tr>

            @endforeach

            <tr class="font-semibold bg-slate-50">
                <td colspan="3" class="p-2 text-right">Total Sewa</td>
                <td class="p-2 text-right">
                    Rp {{ number_format($total_sewa,0,',','.') }}
                </td>
            </tr>

            </tbody>
        </table>
    </div>

    {{-- TOTAL (OPSIONAL TAMBAH DENDA NANTI) --}}
    <div class="bg-slate-50 border rounded-lg p-4 text-sm space-y-2">

        <div class="flex justify-between">
            <span>Total Sewa</span>
            <span class="font-semibold">
                Rp {{ number_format($total_sewa,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between font-bold text-lg border-t pt-2">
            <span>Total Bayar</span>
            <span>
                Rp {{ number_format($total_sewa,0,',','.') }}
            </span>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="mt-10 flex justify-between text-sm">

        <div>
            <p class="text-slate-500">Catatan:</p>
            <p class="text-slate-400">Terima kasih telah menggunakan layanan kami 🙏</p>
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