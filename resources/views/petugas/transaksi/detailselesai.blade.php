@extends('layouts.app')

@section('title','Nota Sewa')

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
            <h2 class="text-xl font-bold text-slate-800">NOTA SEWA</h2>
            <p class="text-sm text-slate-500">Sistem Persewaan Alat Bela Diri</p>
        </div>

        <div class="text-right text-sm">
            <p>No Nota:</p>
            <p class="font-semibold">
                INV-{{ date('Ymd') }}-{{ $transaksi->id }}
            </p>
            <p class="mt-1 text-slate-500">
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
            <p class="text-slate-500">Tanggal Pinjam Rencana</p>
            <p>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_rencana_kembali)->translatedFormat('d F Y') }}
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

    {{-- BARANG --}}
    <h3 class="font-semibold text-slate-700 mb-2">Detail Barang</h3>

    <table class="w-full text-sm mb-6 border border-slate-200">
        <thead class="bg-slate-100 text-slate-600 text-xs uppercase">
            <tr>
                <th class="p-2 border text-left">Barang</th>
                <th class="p-2 border text-center">Qty</th>
                <th class="p-2 border text-right">Harga/Hari</th>
                <th class="p-2 border text-right">Subtotal</th>
            </tr>
        </thead>

        <tbody>
        @php $total_sewa = 0; @endphp

        @forelse($transaksi->detail as $d)
            @php
                $subtotal = $d->qty * $d->harga_per_hari;
                $total_sewa += $subtotal;
            @endphp

            <tr>
                <td class="p-2 border">{{ $d->barang->nama_barang }}</td>
                <td class="p-2 border text-center">{{ $d->qty }}</td>
                <td class="p-2 border text-right">
                    Rp {{ number_format($d->harga_per_hari,0,',','.') }}
                </td>
                <td class="p-2 border text-right">
                    Rp {{ number_format($subtotal,0,',','.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-slate-400">
                    Tidak ada data barang
                </td>
            </tr>
        @endforelse

        <tr class="font-semibold bg-slate-50">
            <td colspan="3" class="p-2 border text-right">Total Sewa</td>
            <td class="p-2 border text-right">
                Rp {{ number_format($total_sewa,0,',','.') }}
            </td>
        </tr>

        </tbody>
    </table>

    {{-- DENDA DETAIL --}}
    <div class="grid grid-cols-2 gap-6 mb-6 text-sm">

        {{-- KETERLAMBATAN --}}
        <div>
            <h4 class="font-semibold text-slate-700 mb-2">Denda Keterlambatan</h4>

            @forelse($transaksi->keterlambatan as $k)
                <div class="flex justify-between border-b py-1">
                    <span>{{ $k->durasi_hari }} hari</span>
                    <span class="text-red-500">
                        Rp {{ number_format($k->total_denda,0,',','.') }}
                    </span>
                </div>
            @empty
                <p class="text-slate-400">Tidak ada</p>
            @endforelse
        </div>

        {{-- KERUSAKAN --}}
        <div>
            <h4 class="font-semibold text-slate-700 mb-2">Denda Kerusakan</h4>

            @forelse($transaksi->kerusakan as $k)
                <div class="flex justify-between border-b py-1">
                    <span>{{ $k->barang->nama_barang }} ({{ $k->qty }})</span>
                    <span class="text-red-500">
                        Rp {{ number_format($k->total_denda,0,',','.') }}
                    </span>
                </div>
            @empty
                <p class="text-slate-400">Tidak ada</p>
            @endforelse
        </div>

    </div>

    {{-- TOTAL --}}
    @php
        $total_denda =
            $transaksi->kerusakan->sum('total_denda') +
            $transaksi->keterlambatan->sum('total_denda');

        $total_bayar = $total_sewa + $total_denda;
    @endphp

    <div class="bg-slate-50 border rounded-lg p-4 text-sm space-y-2">

        <div class="flex justify-between">
            <span>Total Sewa</span>
            <span>Rp {{ number_format($total_sewa,0,',','.') }}</span>
        </div>

        <div class="flex justify-between">
            <span>Total Denda</span>
            <span class="text-red-500">
                Rp {{ number_format($total_denda,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between font-bold text-lg border-t pt-2">
            <span>Total Bayar</span>
            <span>
                Rp {{ number_format($total_bayar,0,',','.') }}
            </span>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="mt-10 flex justify-between text-sm">

        <div>
            <p class="text-slate-500">Catatan:</p>
            <p class="text-slate-400">Terima kasih telah menyewa 🙏</p>
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