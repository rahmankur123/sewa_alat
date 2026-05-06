@extends('layouts.app')

@section('title','Edit Transaksi')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Edit Transaksi
            </h2>
            <p class="text-sm text-gray-500">
                Perbarui barang dan jumlah dalam transaksi
            </p>
        </div>

        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
            ← Kembali
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <form action="{{ route('petugas.transaksi.update',$transaksi->id) }}" method="POST">
        @csrf 
        @method('PUT')

        <div class="space-y-4">

            @foreach($transaksi->detail as $index => $d)
            <div class="flex items-center gap-3">

                {{-- BARANG --}}
                <select name="barang_id[]" 
                    class="flex-1 px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
                    
                    @foreach($barang as $b)
                    <option value="{{ $b->id }}" {{ $b->id==$d->barang_id?'selected':'' }}>
                        {{ $b->nama_barang }}
                    </option>
                    @endforeach

                </select>

                {{-- QTY --}}
                <input type="number" name="qty[]" value="{{ $d->qty }}"
                    class="w-24 px-3 py-2 border rounded-lg text-sm text-center focus:ring-2 focus:ring-indigo-400 outline-none">

            </div>
            @endforeach

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-2 mt-6">

            <a href="{{ url()->previous() }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                Update
            </button>

        </div>

        </form>

    </div>

</div>

@endsection