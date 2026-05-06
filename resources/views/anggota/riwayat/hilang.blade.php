@extends('layouts.app')
@section('title','Barang Hilang Saya')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <h2 class="text-2xl font-semibold text-slate-700 mb-6">
        Riwayat Barang Hilang
    </h2>

    {{-- CARD --}}
    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left w-16">No</th>
                        <th class="px-6 py-3 text-left">Barang</th>
                        <th class="px-6 py-3 text-center w-24">Qty</th>
                        <th class="px-6 py-3 text-right w-40">Denda</th>
                        <th class="px-6 py-3 text-left w-40">Tanggal</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @forelse($data as $item)

                    <tr class="border-t hover:bg-slate-50 transition">

                        {{-- NO --}}
                        <td class="px-6 py-4">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>

                        {{-- BARANG --}}
                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $item->barang->nama_barang }}
                        </td>

                        {{-- QTY --}}
                        <td class="px-6 py-4 text-center">
                            {{ $item->qty }}
                        </td>

                        {{-- DENDA --}}
                        <td class="px-6 py-4 text-right text-red-500 font-semibold">
                            Rp {{ number_format($item->denda,0,',','.') }}
                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-slate-400">
                            Tidak ada riwayat barang hilang
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>

@endsection