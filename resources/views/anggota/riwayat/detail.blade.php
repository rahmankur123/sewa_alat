@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Detail Transaksi
</h2>

{{-- KEMBALI --}}
<a href="{{ url()->previous() }}"
   class="inline-flex cursor-pointer items-center gap-2 mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
    ← Kembali
</a>

{{-- CARD INFO --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">

    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">

        <div>
            <p class="text-slate-500">No Transaksi</p>
            <p class="font-semibold text-slate-700">
                #{{ $transaksi->id }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Nama User</p>
            <p class="font-semibold text-slate-700">
                {{ optional($transaksi->user)->name ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Status</p>
            <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-600">
                {{ $transaksi->status_transaksi }}
            </span>
        </div>

        <div>
            <p class="text-slate-500">Tanggal Pinjam</p>
            <p>
                {{ $transaksi->tanggal_pinjam 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Rencana Kembali</p>
            <p>
                {{ $transaksi->tanggal_kembali_rencana 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

        <div>
            <p class="text-slate-500">Kembali Real</p>
            <p>
                {{ $transaksi->tanggal_kembali_real 
                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali_real)->translatedFormat('d F Y') 
                    : '-' }}
            </p>
        </div>

    </div>

    {{-- TOTAL --}}
    <div class="mt-6 border-t pt-4 flex justify-between items-center">
        <div>
            <p class="text-slate-500 text-sm">Total Harga</p>
            <p class="text-xl font-bold text-slate-800">
                Rp {{ number_format($transaksi->total_harga ?? 0,0,',','.') }}
            </p>
        </div>

        <div class="text-right">
            <p class="text-slate-500 text-sm">Total Item</p>
            <p class="font-semibold text-slate-700">
                {{ $transaksi->detail->sum('qty') ?? 0 }} item
            </p>
        </div>
    </div>

</div>

{{-- DETAIL BARANG --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-slate-700">
            Detail Barang
        </h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm table-fixed">

            <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Barang</th>
                    <th class="px-6 py-3 text-center w-24">Qty</th>
                    <th class="px-6 py-3 text-right w-40">Harga / Hari</th>
                    <th class="px-6 py-3 text-right w-40">Subtotal</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @php $total = 0; @endphp

                @forelse($transaksi->detail as $d)

                    @php
                        $subtotal = $d->subtotal ?? ($d->qty * $d->harga_per_hari);
                        $total += $subtotal;
                    @endphp

                    <tr class="hover:bg-slate-100 transition duration-200">

                        <td class="px-6 py-4">
                            {{ optional($d->barang)->nama_barang ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $d->qty }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            Rp {{ number_format($d->harga_per_hari ?? 0,0,',','.') }}
                        </td>

                        <td class="px-6 py-4 text-right font-semibold">
                            Rp {{ number_format($subtotal,0,',','.') }}
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-slate-400">
                            Tidak ada detail barang
                        </td>
                    </tr>
                @endforelse
            </tbody>

            {{-- TOTAL --}}
            <tfoot>
                <tr class="bg-slate-50 font-semibold">
                    <td colspan="3" class="px-6 py-3 text-right">
                        Total
                    </td>
                    <td class="px-6 py-3 text-right">
                        Rp {{ number_format($total,0,',','.') }}
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>

</div>

@endsection