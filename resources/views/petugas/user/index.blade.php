@extends('layouts.app')

@section('title','Daftar Anggota')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-slate-700">
            Daftar Anggota
        </h1>

        <a href="{{ route('user.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 transition text-sm">
            + Tambah Anggota
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
            placeholder="Cari anggota..."
            class="border px-4 py-2 rounded-lg w-full md:w-1/4 text-sm focus:ring-2 focus:ring-slate-400 outline-none">

        <select name="status"
            class="border px-4 py-2 rounded-lg text-sm focus:ring-2 focus:ring-slate-400 outline-none">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
            <option value="belum_aktif" {{ request('status')=='belum_aktif'?'selected':'' }}>Belum Aktif</option>
        </select>

        <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm hover:bg-slate-700 transition">
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

                {{-- STATUS --}}
                <span class="inline-block px-3 py-1 text-xs rounded-full capitalize
                    {{ $u->status=='aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ str_replace('_',' ',$u->status) }}
                </span>

                {{-- BUTTON --}}
                <div class="flex gap-2 mt-3">

                    {{-- EDIT --}}
                    <a href="{{ route('user.edit',$u->id) }}"
                       class="flex-1 text-center bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition">
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('user.destroy',$u->id) }}" method="POST" class="flex-1">
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
            Tidak ada data anggota
        </div>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

@endsection