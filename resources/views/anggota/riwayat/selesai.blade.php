@extends('layouts.app')
@section('title','Transaksi Selesai')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h2 class="text-3xl font-bold tracking-tight text-slate-800">
            Transaksi Selesai
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Riwayat transaksi yang telah selesai
        </p>

    </div>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                {{-- HEAD --}}
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4 text-left font-semibold w-16">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama User</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal Sewa</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-right font-semibold">Total Sewa</th>
                        <th class="px-6 py-4 text-right font-semibold">Total Denda</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

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

                <tr class="hover:bg-slate-50/70 transition duration-200">

                    {{-- NO --}}
                    <td class="px-6 py-5 text-slate-500 font-medium">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    {{-- NAMA --}}
                    <td class="px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="h-11 w-11 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600 font-semibold">
                                {{ strtoupper(substr($d->user->name ?? '-',0,1)) }}
                            </div>

                            <div class="font-semibold text-slate-700">
                                {{ $d->user->name ?? '-' }}
                            </div>

                        </div>

                    </td>

                    {{-- TANGGAL SEWA --}}
                    <td class="px-6 py-5 text-slate-600">
                        {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>

                    {{-- TANGGAL KEMBALI --}}
                    <td class="px-6 py-5 text-slate-600">
                        {{ \Carbon\Carbon::parse($d->tanggal_kembali_real)->translatedFormat('d F Y') }}
                    </td>

                    {{-- TOTAL SEWA --}}
                    <td class="px-6 py-5 text-right">

                        <span class="inline-block rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
                            Rp {{ number_format($d->total_harga, 0, ',', '.') }}
                        </span>

                    </td>

                    {{-- TOTAL DENDA --}}
                    <td class="px-6 py-5 text-right">

                        <span class="inline-block rounded-xl bg-red-100 px-4 py-2 text-sm font-bold {{ $total_denda > 0 ? 'text-red-700' : 'text-slate-500' }}">
                            Rp {{ number_format($total_denda, 0, ',', '.') }}
                        </span>

                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-5 text-center">

                        <a href="{{ route('anggota.riwayat.detailselesai', $d->id) }}"
                           class="inline-block rounded-xl bg-blue-500 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-600 shadow-sm transition">
                            Detail
                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="10" class="py-16 text-center">

                        <div class="flex flex-col items-center justify-center text-slate-400">

                            <div class="mb-3 text-5xl">
                                📦
                            </div>

                            <p class="text-sm font-medium">
                                Tidak ada transaksi selesai
                            </p>

                        </div>

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $data->links() }}
    </div>

</div>

@endsection