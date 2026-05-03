@extends('layouts.app')

@section('title','Tambah Anggota')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-slate-700">
            Tambah Anggota
        </h2>

        <a href="{{ route('user.index') }}"
           class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition text-sm">
            ← Kembali
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- SECTION: DATA UTAMA --}}
            <div>
                <h3 class="text-sm font-semibold text-slate-500 mb-3 uppercase">
                    Data Utama
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                    </div>

                    {{-- NO HP --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">No Telepon</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                            class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="aktif">Aktif</option>
                            <option value="belum_aktif">Belum Aktif</option>
                        </select>
                    </div>

                </div>
            </div>

            {{-- SECTION: ALAMAT --}}
            <div>
                <h3 class="text-sm font-semibold text-slate-500 mb-3 uppercase">
                    Informasi Tambahan
                </h3>

                <textarea name="alamat" rows="3"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Masukkan alamat...">{{ old('alamat') }}</textarea>
            </div>

            {{-- SECTION: PASSWORD --}}
            <div>
                <h3 class="text-sm font-semibold text-slate-500 mb-3 uppercase">
                    Keamanan
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                    </div>

                </div>
            </div>

            {{-- SECTION: FOTO --}}
            <div>
                <h3 class="text-sm font-semibold text-slate-500 mb-3 uppercase">
                    Foto Profil
                </h3>

                <input type="file" name="foto"
                    class="w-full px-4 py-2 border rounded-lg text-sm bg-white file:mr-3 file:px-3 file:py-1 file:border-0 file:bg-slate-200 file:rounded">
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-2 pt-4 border-t">

                <a href="{{ route('user.index') }}"
                   class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 text-sm">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                    Simpan Anggota
                </button>

            </div>

        </form>

    </div>

</div>

@endsection