@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-700">Daftar Anggota</h1>

        <a href="{{ route('user.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Tambah Anggota
        </a>
    </div>

    <!-- FILTER & SEARCH -->
    <form method="GET" 
        class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6 flex flex-wrap gap-3 items-center">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari anggota..."
            class="border px-3 py-2 rounded-lg w-full md:w-1/4 text-sm focus:ring-2 focus:ring-slate-400">

        <select name="status" class="border px-3 py-2 rounded-lg text-sm">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
            <option value="belum_aktif" {{ request('status')=='belum_aktif'?'selected':'' }}>Belum Aktif</option>
        </select>

        <button class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-slate-700">
            Filter
        </button>

    </form>

    <!-- GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($users as $u)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden 
                    hover:shadow-lg hover:-translate-y-1 transition duration-300">

            <!-- FOTO -->
            <img src="{{ $u->foto ? asset('storage/'.$u->foto) : asset('img/default.png') }}"
                 class="h-40 w-full object-cover">

            <div class="p-4 space-y-2">

                <!-- NAMA -->
                <h2 class="font-semibold text-lg text-slate-700">
                    {{ $u->name }}
                </h2>

                <!-- EMAIL -->
                <p class="text-xs text-slate-400">
                    {{ $u->email }}
                </p>

                <!-- ALAMAT -->
                <p class="text-sm text-slate-500 line-clamp-2">
                    {{ $u->alamat ?? '-' }}
                </p>

                <!-- STATUS -->
                <span class="inline-block px-2 py-1 text-xs rounded-full
                    {{ $u->status=='aktif' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $u->status=='belum_aktif' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ strtoupper($u->status) }}
                </span>

                <!-- BUTTON -->
                <div class="flex gap-2 mt-3">

                    {{-- EDIT --}}
                    <a href="{{ route('user.edit',$u->id) }}"
                       class="flex-1 text-center bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('user.destroy',$u->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus user?')"
                            class="w-full bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
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

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>
@endsection