@extends('layouts.app')
@section('title','Transaksi Terdenda')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h2 class="text-3xl font-bold tracking-tight text-slate-800">
            Transaksi Terdenda
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Daftar transaksi dengan pembayaran denda
        </p>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 shadow-sm">

        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100">
            ✅
        </div>

        <div class="text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>

    </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
    <div class="mb-6 flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">

        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
            ⚠️
        </div>

        <div class="text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>

    </div>
    @endif

    {{-- SEARCH --}}
    <div class="mb-6">

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-4">

            <form method="GET" class="flex flex-col md:flex-row gap-3">

                <div class="flex-1">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama user..."
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-slate-100 transition">

                </div>

                <button
                    class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 hover:shadow-md transition duration-200">
                    Cari
                </button>

            </form>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                {{-- HEAD --}}
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama User</th>
                        <th class="px-6 py-4 text-right font-semibold">Kerusakan</th>
                        <th class="px-6 py-4 text-right font-semibold">Keterlambatan</th>
                        <th class="px-6 py-4 text-right font-semibold">Barang Hilang</th>
                        <th class="px-6 py-4 text-right font-semibold">Total Denda</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($data as $d)

                    @php
                        $dendaKerusakan = $d->kerusakan?->sum('total_denda') ?? 0;
                        $dendaTerlambat = $d->keterlambatan?->sum('total_denda') ?? 0;
                        $dendaHilang = $d->hilang?->sum('denda') ?? 0;
                        $totalDenda = $dendaKerusakan + $dendaTerlambat + $dendaHilang;
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

                        {{-- KERUSAKAN --}}
                        <td class="px-6 py-5 text-right">

                            @if($dendaKerusakan > 0)

                                <span class="inline-block rounded-xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600">
                                    Rp {{ number_format($dendaKerusakan,0,',','.') }}
                                </span>

                            @else
                                <span class="text-slate-400">-</span>
                            @endif

                        </td>

                        {{-- KETERLAMBATAN --}}
                        <td class="px-6 py-5 text-right">

                            @if($dendaTerlambat > 0)

                                <span class="inline-block rounded-xl bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-500">
                                    Rp {{ number_format($dendaTerlambat,0,',','.') }}
                                </span>

                            @else
                                <span class="text-slate-400">-</span>
                            @endif

                        </td>

                        {{-- BARANG HILANG --}}
                        <td class="px-6 py-5 text-right">

                            @if($dendaHilang > 0)

                                <span class="inline-block rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600">
                                    Rp {{ number_format($dendaHilang,0,',','.') }}
                                </span>

                            @else
                                <span class="text-slate-400">-</span>
                            @endif

                        </td>

                        {{-- TOTAL --}}
                        <td class="px-6 py-5 text-right">

                            <span class="inline-block rounded-xl px-4 py-2 text-sm font-bold
                                {{ $totalDenda > 0
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-slate-100 text-slate-400' }}">

                                Rp {{ number_format($totalDenda,0,',','.') }}

                            </span>

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <div class="flex flex-wrap justify-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('petugas.transaksi.detailDenda',$d->id) }}"
                                   class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200 transition">
                                   Detail
                                </a>

                                {{-- LUNAS --}}
                                <form action="{{ route('petugas.transaksi.lunas',$d->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin transaksi ini sudah lunas?')">

                                    @csrf

                                    <button type="submit"
                                        class="rounded-xl cursor-pointer bg-emerald-500 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-600 shadow-sm transition">
                                        Lunas
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="py-16 text-center">

                            <div class="flex flex-col items-center justify-center text-slate-400">

                                <div class="mb-3 text-5xl">
                                    📦
                                </div>

                                <p class="text-sm font-medium">
                                    Data tidak ada
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