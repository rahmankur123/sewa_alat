@extends('layouts.app')

@section('title','Daftar Petugas')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-slate-700">
            Daftar Petugas
        </h1>

        <a href="{{ route('pemilik.user.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 transition text-sm">
            + Tambah Petugas
        </a>
    </div>

    {{-- NOTIF --}}
    @if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
        {{ session('error') }}
    </div>
    @endif

    {{-- FILTER --}}
    <form method="GET" 
        class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6 flex flex-wrap gap-3 items-center">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari petugas..."
            class="border border-slate-200 px-4 py-2 rounded-lg w-full md:w-1/4 text-sm focus:ring-2 focus:ring-slate-400 outline-none">


        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 cursor-pointer transition">
            Filter
        </button>

    </form>

    {{-- GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($users as $u)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden 
                    hover:shadow-md hover:-translate-y-1 transition duration-300">

            {{-- FOTO --}}
            <img src="{{ $u->foto ? asset('storage/'.$u->foto) : asset('img/default.png') }}"
                 class="h-40 w-full object-cover">

            <div class="p-4 space-y-2">

                {{-- NAMA --}}
                <h2 class="font-semibold text-lg text-slate-700">
                    {{ $u->name }}
                </h2>

                {{-- EMAIL --}}
                <p class="text-xs text-slate-400">
                    {{ $u->email }}
                </p>

                {{-- ALAMAT --}}
                <p class="text-sm text-slate-500 line-clamp-2">
                    {{ $u->alamat ?? '-' }}
                </p>

                {{-- BUTTON --}}
                <div class="flex gap-2 mt-3">

                    {{-- EDIT --}}
                    <a href="{{ route('pemilik.user.edit',$u->id) }}"
                       class="flex-1 text-center cursor-pointer bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition">
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('pemilik.user.destroy',$u->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus anggota ini?')"
                            class="w-full bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @empty
        <div class="col-span-full text-center text-slate-400 py-10">
            Tidak ada data Petugas
        </div>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

@endsection