@extends('layouts.app')
@section('title','Pengembalian Barang')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Pengembalian Barang
            </h2>
            <p class="text-sm text-gray-500">
                Proses pengembalian dan pencatatan kerusakan / kehilangan
            </p>
        </div>

        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm w-fit">
            ← Kembali
        </a>
    </div>

    <form method="POST"
    action="{{ route('petugas.transaksi.prosesKembalikan',$transaksi->id) }}">
    @csrf

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-6">

        {{-- INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">

            <div>
                <p class="text-gray-500">Nama Penyewa</p>
                <p class="font-semibold text-gray-800">
                    {{ $transaksi->user->name }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal Pinjam</p>
                <p class="text-gray-700">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Rencana Kembali</p>
                <p class="text-gray-700">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali_rencana)->translatedFormat('d F Y') }}
                </p>
            </div>

        </div>

        {{-- TANGGAL KEMBALI --}}
        <div>
            <label class="block text-sm text-gray-600 mb-1">
                Tanggal Kembali
            </label>

            <input type="date"
                name="tanggal_kembali_real"
                required
                class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
        </div>

        {{-- KERUSAKAN --}}
        <div>
            <h3 class="font-semibold text-gray-800 mb-3">
                Kerusakan Barang
            </h3>

            <div class="space-y-3">

                @forelse($transaksi->detail as $item)
                <div class="bg-gray-50 rounded-xl p-4">

                    <div class="flex justify-between items-center mb-2">
                        <p class="font-medium text-gray-800">
                            {{ $item->barang->nama_barang }}
                        </p>

                        <span class="text-xs text-gray-500">
                            Qty: {{ $item->qty }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @for($i=1;$i<=$item->qty;$i++)
                        <label class="flex items-center gap-2 text-xs bg-white px-3 py-1 rounded-lg shadow-sm cursor-pointer hover:bg-gray-100">
                            
                            <input type="checkbox"
                                name="rusak[{{ $item->barang_id }}][]"
                                value="1"
                                class="accent-red-500">

                            Unit {{ $i }}
                        </label>
                        @endfor
                    </div>

                </div>
                @empty
                <p class="text-gray-400 text-sm">
                    Tidak ada data barang
                </p>
                @endforelse

            </div>
        </div>

        {{-- BARANG HILANG --}}
        <div>
            <h3 class="font-semibold text-gray-800 mb-3">
                Barang Hilang
            </h3>

            <div class="space-y-3">

                @forelse($transaksi->detail as $item)
                <div class="bg-gray-50 rounded-xl p-4">

                    <div class="flex justify-between items-center mb-2">
                        <p class="font-medium text-gray-800">
                            {{ $item->barang->nama_barang }}
                        </p>

                        <span class="text-xs text-gray-500">
                            Dipinjam: {{ $item->qty }}
                        </span>
                    </div>

                    <input type="number"
                        name="hilang[{{ $item->barang_id }}]"
                        min="0"
                        max="{{ $item->qty }}"
                        value="0"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 outline-none">

                    <p class="text-xs text-gray-400 mt-1">
                        Maksimal {{ $item->qty }}
                    </p>

                </div>
                @empty
                <p class="text-gray-400 text-sm">
                    Tidak ada data barang
                </p>
                @endforelse

            </div>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end pt-4">
            <button class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                Simpan Pengembalian
            </button>
        </div>

    </div>

    </form>

</div>

@endsection