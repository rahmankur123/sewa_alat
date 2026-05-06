@extends('layouts.app')
@section('title','Barang Hilang Saya')

@section('content')

<h2 class="text-2xl font-semibold text-slate-700 mb-6">
    Riwayat Barang Hilang
</h2>

<div class="bg-white shadow rounded-xl border border-slate-200">

    <table class="w-full text-sm">
        <thead class="bg-slate-100 text-slate-600">
            <tr>
                <th class="p-3 text-left">No</th>
                <th class="p-3 text-left">Barang</th>
                <th class="p-3 text-left">Qty</th>
                <th class="p-3 text-left">Denda</th>
                <th class="p-3 text-left">Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $i => $item)
            <tr class="border-t">
                <td class="p-3">{{ $i + 1 }}</td>
                <td class="p-3">{{ $item->barang->nama_barang }}</td>
                <td class="p-3">{{ $item->qty }}</td>
                <td class="p-3 text-red-600 font-semibold">
                    Rp {{ number_format($item->denda) }}
                </td>
                <td class="p-3">
                    {{ $item->created_at->format('d-m-Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center p-4 text-slate-400">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection