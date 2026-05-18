@extends('layouts.app')
@section('title','Transaksi Selesai')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <h2 class="text-2xl font-semibold text-slate-700 mb-6">
        Transaksi Selesai
    </h2>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left w-16">No</th>
                        <th class="px-6 py-3 text-left">Nama User</th>
                        <th class="px-6 py-3 text-left w-40">Tanggal Sewa</th>
                        <th class="px-6 py-3 text-left w-40">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-right w-40">Total Sewa</th>
                        <th class="px-6 py-3 text-right w-40">Denda Keterlambatan</th>
                        <th class="px-6 py-3 text-right w-40">Denda Kerusakan</th>
                        <th class="px-6 py-3 text-right w-40">Denda Barang Hilang</th>
                        <th class="px-6 py-3 text-right w-40">Total Denda</th>
                        <th class="px-6 py-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                @forelse($data as $d)

                @php
                    // Denda keterlambatan
                    $denda_keterlambatan = $d->keterlambatan?->sum('total_denda') ?? 0;

                    // Denda kerusakan
                    $denda_kerusakan = $d->kerusakan?->sum('total_denda') ?? 0;

                    // Denda barang hilang
                    $denda_hilang = $d->hilang?->sum('denda') ?? 0;

                    // Total seluruh denda
                    $total_denda = $denda_keterlambatan + $denda_kerusakan + $denda_hilang;
                @endphp

                <tr class="border-t hover:bg-slate-50 transition">

                    {{-- NO --}}
                    <td class="px-6 py-4 font-medium">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    {{-- NAMA --}}
                    <td class="px-6 py-4">
                        {{ $d->user->name ?? '-' }}
                    </td>

                    {{-- TANGGAL SEWA --}}
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    {{-- TANGGAL KEMBALI --}}
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_kembali_real)->translatedFormat('d F Y') }}
                    </td>

                    {{-- TOTAL SEWA --}}
                    <td class="px-6 py-4 text-right font-medium">
                        Rp {{ number_format($d->total_harga, 0, ',', '.') }}
                    </td>

                    {{-- DENDA KETERLAMBATAN --}}
                    <td class="px-6 py-4 text-right">
                        <span class="{{ $denda_keterlambatan > 0 ? 'text-red-500 font-semibold' : 'text-slate-400' }}">
                            Rp {{ number_format($denda_keterlambatan, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- DENDA KERUSAKAN --}}
                    <td class="px-6 py-4 text-right">
                        <span class="{{ $denda_kerusakan > 0 ? 'text-red-500 font-semibold' : 'text-slate-400' }}">
                            Rp {{ number_format($denda_kerusakan, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- DENDA BARANG HILANG --}}
                    <td class="px-6 py-4 text-right">
                        <span class="{{ $denda_hilang > 0 ? 'text-red-500 font-semibold' : 'text-slate-400' }}">
                            Rp {{ number_format($denda_hilang, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- TOTAL DENDA --}}
                    <td class="px-6 py-4 text-right font-semibold">
                        <span class="{{ $total_denda > 0 ? 'text-red-600' : 'text-slate-400' }}">
                            Rp {{ number_format($total_denda, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('anggota.riwayat.detailselesai', $d->id) }}"
                           class="px-3 py-1 text-xs bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                            Detail
                        </a>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="10" class="text-center py-10 text-slate-400">
                        Tidak ada transaksi selesai
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