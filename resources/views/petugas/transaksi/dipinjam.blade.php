@extends('layouts.app')
@section('title','Transaksi Dipinjam')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>
            <h2 class="text-3xl font-bold tracking-tight text-slate-800">
                Transaksi Dipinjam
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Daftar transaksi yang sedang berlangsung
            </p>
        </div>

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
                    class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 hover:shadow-md cursor-pointer transition duration-200">
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
                        <th class="px-6 py-4 text-center font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama User</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal Sewa</th>
                        <th class="px-6 py-4 text-left font-semibold">Rencana Kembali</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($data as $d)

                    <tr class="hover:bg-slate-50/70 transition duration-200">

                        {{-- NO --}}
                        <td class="px-6 py-5 text-center text-slate-500 font-medium">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="h-11 w-11 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600 font-semibold">
                                    {{ strtoupper(substr($d->user->name,0,1)) }}
                                </div>

                                <div>
                                    <div class="font-semibold text-slate-700">
                                        {{ $d->user->name }}
                                    </div>
                                </div>

                            </div>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-5 text-slate-600">
                            {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                        </td>

                        {{-- KEMBALI --}}
                        <td class="px-6 py-5 text-slate-600">
                            {{ \Carbon\Carbon::parse($d->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <div class="flex flex-wrap justify-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('petugas.transaksi.detail', $d->id) }}"
                                   class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200 transition">
                                   Detail
                                </a>

                                {{-- DIKEMBALIKAN --}}
                                <a href="{{ route('petugas.transaksi.formKembalikan',$d->id) }}"
                                   class="rounded-xl bg-emerald-500 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-600 shadow-sm transition">
                                   Dikembalikan
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('petugas.transaksi.hapus',$d->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin mau hapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="rounded-xl cursor-pointer bg-rose-500 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-600 shadow-sm transition">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="py-16 text-center">

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