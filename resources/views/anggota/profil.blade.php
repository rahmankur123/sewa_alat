@extends('layouts.app')
@section('title','Edit Profil')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-slate-700">
            Edit Profil
        </h2>
    </div>

    {{-- NOTIF --}}
    @if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 text-sm">

                {{-- FOTO --}}
                <div class="col-span-2 text-center">
                    <img src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('img/default.png') }}"
                         class="w-32 h-32 object-cover rounded-full mx-auto mb-3 border">

                    <input type="file" name="foto"
                        class="text-sm">
                </div>

                {{-- NAMA --}}
                <div>
                    <label class="text-slate-600">Nama</label>
                    <input type="text" name="name"
                        value="{{ old('name',$user->name) }}"
                        class="w-full px-3 py-2 border rounded-lg">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="text-slate-600">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email',$user->email) }}"
                        class="w-full px-3 py-2 border rounded-lg">
                </div>

                {{-- NO HP --}}
                <div>
                    <label class="text-slate-600">No HP</label>
                    <input type="text" name="no_hp"
                        value="{{ old('no_hp',$user->no_hp) }}"
                        class="w-full px-3 py-2 border rounded-lg">
                </div>

                {{-- ALAMAT --}}
                <div class="col-span-2">
                    <label class="text-slate-600">Alamat</label>
                    <textarea name="alamat" rows="3"
                        class="w-full px-3 py-2 border rounded-lg">{{ old('alamat',$user->alamat) }}</textarea>
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="text-slate-600">Password Baru</label>
                    <input type="password" name="password"
                        class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="text-slate-600">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-3 py-2 border rounded-lg">
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-2 mt-6">

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection