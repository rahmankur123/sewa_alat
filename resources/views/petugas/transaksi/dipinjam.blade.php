@extends('layouts.app')
@section('title','Transaksi Dipinjam')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Transaksi Dipinjam
            </h2>
            <p class="text-sm text-gray-500">
                Daftar transaksi yang sedang berlangsung
            </p>
        </div>
    </div>

    {{-- NOTIF --}}
    @if(session('success'))
    <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- SEARCH --}}
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-3">

        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama user..."
                class="px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-400 outline-none">

            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition">
                Cari
            </button>
        </form>

    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                {{-- HEAD --}}
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-center">No</th>
                        <th class="p-4 text-left">Nama User</th>
                        <th class="p-4 text-left">Tanggal Sewa</th>
                        <th class="p-4 text-left">Rencana Kembali</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @forelse($data as $d)
                    <tr class="border-b last:border-0 hover:bg-gray-50 transition">

                        {{-- NO --}}
                        <td class="p-4 text-center">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td class="p-4 font-medium text-gray-800">
                            {{ $d->user->name }}
                        </td>

                        {{-- TANGGAL --}}
                        <td class="p-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->translatedFormat('d F Y') }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($d->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                        </td>

                        {{-- AKSI --}}
                        <td class="p-4 text-center">
                            <div class="flex flex-wrap justify-center gap-2">

                                {{-- HAPUS --}}
                                <form action="{{ route('petugas.transaksi.hapus',$d->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin mau hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>

                                {{-- DIKEMBALIKAN --}}
                                <a href="{{ route('petugas.transaksi.formKembalikan',$d->id) }}"
                                   class="px-3 py-1.5 text-xs bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                                   Dikembalikan
                                </a>

                                {{-- DETAIL --}}
                                <a href="{{ route('petugas.transaksi.detail', $d->id) }}"
                                   class="px-3 py-1.5 text-xs border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition">
                                   Detail
                                </a>

                            </div>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400">
                            Data tidak ada
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