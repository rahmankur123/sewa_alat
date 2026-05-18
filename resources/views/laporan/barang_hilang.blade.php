@extends('layouts.app')
@section('title','Laporan Barang Hilang')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Laporan Barang Hilang
        </h1>

        <a href="{{ route(auth()->user()->role . '.laporan.barangHilang.pdf', request()->query()) }}"
        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Export PDF
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="bg-white p-4 rounded-xl shadow border mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal Awal
                </label>
                <input type="date"
                       name="tanggal_awal"
                       value="{{ request('tanggal_awal') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal Akhir
                </label>
                <input type="date"
                       name="tanggal_akhir"
                       value="{{ request('tanggal_akhir') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- BUTTON --}}
            <div class="flex gap-2 items-center">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg h-10 hover:bg-blue-700 inline-flex items-center justify-center">
                    Filter
                </button>

                <a href="{{ url(auth()->user()->role . '/laporan/barang-hilang') }}"
                class="bg-red-500 text-white px-4 py-2 rounded-lg h-10 inline-flex items-center justify-center">
                    Reset
                </a>
            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Penyewa</th>
                    <th class="px-6 py-3 text-left">Barang Hilang</th>
                    <th class="px-6 py-3 text-right">Total Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $t)
                @php
                    $total = $t->hilang?->sum('denda') ?? 0;
                @endphp
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d-m-Y') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $t->user->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @foreach($t->hilang ?? [] as $h)
                            <div>
                                {{ $h->barang->nama_barang ?? '-' }}
                                ({{ $h->qty }})
                            </div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-right text-red-600 font-semibold">
                        Rp {{ number_format($total,0,',','.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>
@endsection