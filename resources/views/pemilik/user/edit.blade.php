@extends('layouts.app')

@section('title','Detail Petugas')

@section('content')

<div 
    x-data="{ editMode: false }"
    class="max-w-6xl mx-auto px-4 py-6"
>

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Detail Petugas
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Informasi lengkap data Petugas
            </p>
        </div>

        <div class="flex items-center gap-3">

            {{-- EDIT --}}
            <button
                @click="editMode = !editMode"
                type="button"
                class="px-5 py-2.5 rounded-xl cursor-pointer font-bold text-sm shadow-sm transition
                       bg-amber-500 hover:bg-amber-600 text-white"
            >
                <span x-text="editMode ? 'Batal Edit' : 'Edit Data'"></span>
            </button>

            {{-- BACK --}}
            <a href="{{ route('pemilik.user.index') }}"
               class="px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm transition
                      bg-slate-700 hover:bg-slate-800 text-white">
                ← Kembali
            </a>

        </div>

    </div>


    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
            <div class="font-bold text-red-700 mb-2">
                Terjadi Kesalahan
            </div>

            <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form
        action="{{ route('pemilik.user.update',$user->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ========================= --}}
            {{-- FOTO PROFIL --}}
            {{-- ========================= --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 h-fit">

                <div class="flex flex-col items-center text-center">

                    {{-- FOTO --}}
                    @if($user->foto)
                        <img
                            src="{{ asset('storage/'.$user->foto) }}"
                            class="w-40 h-40 rounded-3xl object-cover border-4 border-slate-100 shadow"
                        >
                    @else
                        <div class="w-40 h-40 rounded-3xl bg-slate-100 flex items-center justify-center text-5xl">
                            👤
                        </div>
                    @endif

                    <h2 class="mt-4 text-xl font-black text-slate-800">
                        {{ $user->name }}
                    </h2>

                    <p class="text-sm text-slate-500 capitalize">
                        {{ $user->role }}
                    </p>

                </div>

                {{-- UPLOAD FOTO --}}
                <div
                    x-show="editMode"
                    x-transition
                    class="mt-6"
                >
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Ganti Foto Profil
                    </label>

                    <input
                        type="file"
                        name="foto"
                        class="w-full text-sm border border-slate-300 rounded-xl
                               file:border-0 file:bg-blue-600 file:text-white
                               file:px-4 file:py-2 file:mr-3 file:rounded-l-xl
                               hover:file:bg-blue-700"
                    >
                </div>

            </div>


            {{-- ========================= --}}
            {{-- DETAIL DATA --}}
            {{-- ========================= --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">

                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h2 class="text-xl font-black text-slate-800">
                                Informasi Anggota
                            </h2>

                            <p class="text-sm text-slate-500">
                                Data pribadi anggota
                            </p>
                        </div>

                        <div
                            class="px-3 py-1 rounded-full text-xs font-bold
                                   bg-blue-100 text-blue-700"
                        >
                            ID #{{ $user->id }}
                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- NAMA --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Nama Lengkap
                            </label>

                            <template x-if="!editMode">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-semibold text-slate-700">
                                    {{ $user->name }}
                                </div>
                            </template>

                            <input
                                x-show="editMode"
                                type="text"
                                name="name"
                                value="{{ old('name',$user->name) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3
                                       focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                       outline-none"
                            >
                        </div>


                        {{-- EMAIL --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Email
                            </label>

                            <template x-if="!editMode">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-semibold text-slate-700">
                                    {{ $user->email }}
                                </div>
                            </template>

                            <input
                                x-show="editMode"
                                type="email"
                                name="email"
                                value="{{ old('email',$user->email) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3
                                       focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                       outline-none"
                            >
                        </div>


                        {{-- NO HP --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Nomor HP
                            </label>

                            <template x-if="!editMode">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-semibold text-slate-700">
                                    {{ $user->no_hp ?? '-' }}
                                </div>
                            </template>

                            <input
                                x-show="editMode"
                                type="text"
                                name="no_hp"
                                value="{{ old('no_hp',$user->no_hp) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3
                                       focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                       outline-none"
                            >
                        </div>


                        {{-- ROLE --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Role
                            </label>

                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-semibold capitalize text-slate-700">
                                {{ $user->role }}
                            </div>
                        </div>


                        {{-- ALAMAT --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Alamat
                            </label>

                            <template x-if="!editMode">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-semibold text-slate-700 min-h-[90px]">
                                    {{ $user->alamat ?? '-' }}
                                </div>
                            </template>

                            <textarea
                                x-show="editMode"
                                name="alamat"
                                rows="4"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3
                                       focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                       outline-none"
                            >{{ old('alamat',$user->alamat) }}</textarea>
                        </div>


                        {{-- PASSWORD --}}
                        <div
                            x-show="editMode"
                            x-transition
                        >
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Password Baru
                            </label>

                            <input
                                type="password"
                                name="password"
                                placeholder="Kosongkan jika tidak diubah"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3
                                       focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                       outline-none"
                            >
                        </div>


                        {{-- PASSWORD CONFIRM --}}
                        <div
                            x-show="editMode"
                            x-transition
                        >
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3
                                       focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                       outline-none"
                            >
                        </div>

                    </div>


                    {{-- BUTTON SAVE --}}
                    <div
                        x-show="editMode"
                        x-transition
                        class="mt-8 pt-6 border-t border-slate-200 flex justify-end"
                    >
                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                                   text-white font-bold shadow-sm transition"
                        >
                            Simpan Perubahan
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection