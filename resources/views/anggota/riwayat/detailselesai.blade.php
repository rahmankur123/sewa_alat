@extends('layouts.app')

@section('title','Nota Sewa')

@section('content')

{{-- ACTION --}}
<div class="no-print mb-5 flex flex-col sm:flex-row justify-between gap-3 max-w-4xl mx-auto">

    <a href="{{ url()->previous() }}"
       class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition cursor-pointer shadow-sm text-sm font-medium">
        ← Kembali
    </a>

    <button onclick="window.print()"
        class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition cursor-pointer shadow-sm text-sm font-medium">
        🖨️ Cetak Nota
    </button>

</div>

{{-- NOTA --}}
<div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-slate-800 via-indigo-700 to-slate-900 px-6 md:px-8 py-6 text-white">

        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">

            <div>
                <h2 class="text-2xl font-bold tracking-wide">
                    NOTA SEWA
                </h2>

                <p class="text-sm text-indigo-100 mt-1">
                    Sistem Persewaan Alat Bela Diri
                </p>
            </div>

            <div class="md:text-right text-sm">
                <p class="text-indigo-100">No Nota</p>

                <p class="font-semibold text-white">
                    INV-{{ date('Ymd') }}-{{ $transaksi->id }}
                </p>

                <p class="text-indigo-200 mt-1">
                    {{ now()->translatedFormat('d F Y') }}
                </p>
            </div>

        </div>

    </div>

    <div class="p-6 md:p-8">

        {{-- INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm mb-8">

            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-slate-500 mb-1">Nama Penyewa</p>
                <p class="font-semibold text-slate-800">
                    {{ $transaksi->user->name }}
                </p>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-slate-500 mb-1">Status</p>

                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-600 capitalize">
                    {{ $transaksi->status_transaksi }}
                </span>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-slate-500 mb-1">Tanggal Pinjam</p>

                <p class="text-slate-700">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-slate-500 mb-1">Tanggal Kembali Rencana</p>

                <p class="text-slate-700">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 md:col-span-2">
                <p class="text-slate-500 mb-1">Tanggal Kembali</p>

                <p class="text-slate-700">
                    {{ $transaksi->tanggal_kembali_real 
                        ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                        : '-' }}
                </p>
            </div>

        </div>

        {{-- HITUNG TOTAL --}}
        @php
            $total_sewa   = $transaksi->detail->sum('subtotal');
            $denda_telat  = $transaksi->keterlambatan->sum('total_denda');
            $denda_rusak  = $transaksi->kerusakan->sum('total_denda');
            $denda_hilang = $transaksi->barangHilang->sum('denda');

            $total_denda = $denda_telat + $denda_rusak + $denda_hilang;
            $total_bayar = $total_sewa + $total_denda;
        @endphp

        {{-- BARANG --}}
        <div class="mb-8">

            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-slate-800 text-lg">
                    Detail Barang
                </h3>

                <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
                    {{ $transaksi->detail->count() }} Item
                </span>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-xl">

                <table class="w-full text-sm">

                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="p-3 text-left">Barang</th>
                            <th class="p-3 text-center">Qty</th>
                            <th class="p-3 text-right">Harga / Hari</th>
                            <th class="p-3 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($transaksi->detail as $d)

                        <tr class="border-t hover:bg-slate-50 transition">

                            <td class="p-3 text-slate-700">
                                {{ $d->barang->nama_barang }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $d->qty }}
                            </td>

                            <td class="p-3 text-right">
                                Rp {{ number_format($d->harga_per_hari,0,',','.') }}
                            </td>

                            <td class="p-3 text-right font-medium text-slate-800">
                                Rp {{ number_format($d->subtotal,0,',','.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-6 text-slate-400">
                                Tidak ada data barang
                            </td>
                        </tr>

                    @endforelse

                    <tr class="bg-slate-50 border-t font-semibold">

                        <td colspan="3" class="p-3 text-right">
                            Total Sewa
                        </td>

                        <td class="p-3 text-right text-slate-800">
                            Rp {{ number_format($total_sewa,0,',','.') }}
                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

        {{-- DENDA --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8 text-sm">

            {{-- TELAT --}}
            <div class="border border-slate-200 rounded-xl p-4">

                <h4 class="font-semibold text-slate-800 mb-3">
                    Keterlambatan
                </h4>

                @forelse($transaksi->keterlambatan as $k)

                    <div class="flex justify-between py-2 border-b last:border-0">

                        <span class="text-slate-600">
                            {{ $k->durasi_hari }} hari
                        </span>

                        <span class="text-red-500 font-medium">
                            Rp {{ number_format($k->total_denda,0,',','.') }}
                        </span>

                    </div>

                @empty

                    <p class="text-slate-400">
                        Tidak ada
                    </p>

                @endforelse

            </div>

            {{-- RUSAK --}}
            <div class="border border-slate-200 rounded-xl p-4">

                <h4 class="font-semibold text-slate-800 mb-3">
                    Kerusakan
                </h4>

                @forelse($transaksi->kerusakan as $k)

                    <div class="flex justify-between py-2 border-b last:border-0 gap-2">

                        <span class="text-slate-600">
                            {{ $k->barang->nama_barang }} ({{ $k->qty }})
                        </span>

                        <span class="text-red-500 font-medium whitespace-nowrap">
                            Rp {{ number_format($k->total_denda,0,',','.') }}
                        </span>

                    </div>

                @empty

                    <p class="text-slate-400">
                        Tidak ada
                    </p>

                @endforelse

            </div>

            {{-- HILANG --}}
            <div class="border border-slate-200 rounded-xl p-4">

                <h4 class="font-semibold text-slate-800 mb-3">
                    Barang Hilang
                </h4>

                @forelse($transaksi->barangHilang as $h)

                    <div class="flex justify-between py-2 border-b last:border-0 gap-2">

                        <span class="text-slate-600">
                            {{ $h->barang->nama_barang }} ({{ $h->qty }})
                        </span>

                        <span class="text-red-500 font-medium whitespace-nowrap">
                            Rp {{ number_format($h->denda,0,',','.') }}
                        </span>

                    </div>

                @empty

                    <p class="text-slate-400">
                        Tidak ada
                    </p>

                @endforelse

            </div>

        </div>

        {{-- TOTAL --}}
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-sm space-y-3">

            <div class="flex justify-between">
                <span class="text-slate-600">
                    Total Sewa
                </span>

                <span class="font-medium">
                    Rp {{ number_format($total_sewa,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-600">
                    Total Denda
                </span>

                <span class="font-medium text-red-500">
                    Rp {{ number_format($total_denda,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between border-t pt-3 text-lg font-bold">

                <span class="text-slate-800">
                    Total Bayar
                </span>

                <span class="text-indigo-700">
                    Rp {{ number_format($total_bayar,0,',','.') }}
                </span>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="mt-12 flex flex-col md:flex-row justify-between gap-8 text-sm">

            <div>
                <p class="text-slate-500 mb-1">
                    Catatan:
                </p>

                <p class="text-slate-400">
                    Terima kasih telah menyewa alat bela diri 🙏
                </p>
            </div>

            <div class="text-right">

                <p class="text-slate-600">
                    Petugas
                </p>

                <div class="h-16"></div>

                <p class="border-t border-slate-400 inline-block px-5 pt-2 font-medium text-slate-800">
                    {{ auth()->user()->name ?? 'Admin' }}
                </p>

            </div>

        </div>

    </div>

</div>

@endsection