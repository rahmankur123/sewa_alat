@extends('layouts.app')

@section('title','Detail Anggota')

@section('content')

<div x-data="{ editMode: false }" class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-slate-700">
            Detail Anggota
        </h2>

        <div class="flex gap-2">

            {{-- BUTTON EDIT --}}
            <button @click="editMode = !editMode"
                class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                <span x-text="editMode ? 'Batal' : 'Edit'"></span>
            </button>

            {{-- KEMBALI --}}
            <a href="{{ route('user.index') }}"
               class="px-4 py-2 text-sm bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition">
                ← Kembali
            </a>

        </div>
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

        <form action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6 text-sm">

                {{-- NAMA --}}
                <div>
                    <label class="block text-slate-500 mb-1">Nama</label>

                    <template x-if="!editMode">
                        <p class="font-semibold text-slate-700">{{ $user->name }}</p>
                    </template>

                    <input x-show="editMode" type="text" name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-slate-500 mb-1">Email</label>

                    <template x-if="!editMode">
                        <p class="font-semibold text-slate-700">{{ $user->email }}</p>
                    </template>

                    <input x-show="editMode" type="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                {{-- NO HP --}}
                <div>
                    <label class="block text-slate-500 mb-1">No HP</label>

                    <template x-if="!editMode">
                        <p class="font-semibold text-slate-700">{{ $user->no_hp }}</p>
                    </template>

                    <input x-show="editMode" type="text" name="no_hp"
                        value="{{ old('no_hp', $user->no_hp) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-slate-500 mb-1">Status</label>

                    <template x-if="!editMode">
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600 capitalize">
                            {{ $user->status }}
                        </span>
                    </template>

                    <select x-show="editMode" name="status"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="aktif" {{ old('status',$user->status)=='aktif'?'selected':'' }}>Aktif</option>
                        <option value="belum_aktif" {{ old('status',$user->status)=='belum_aktif'?'selected':'' }}>Belum Aktif</option>
                    </select>
                </div>

                {{-- ALAMAT --}}
                <div class="col-span-2">
                    <label class="block text-slate-500 mb-1">Alamat</label>

                    <template x-if="!editMode">
                        <p class="font-semibold text-slate-700">
                            {{ $user->alamat ?? '-' }}
                        </p>
                    </template>

                    <textarea x-show="editMode" name="alamat" rows="3"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">{{ old('alamat',$user->alamat) }}</textarea>
                </div>

                {{-- PASSWORD --}}
                <div x-show="editMode">
                    <label class="block text-slate-500 mb-1">Password (opsional)</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div x-show="editMode">
                    <label class="block text-slate-500 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                {{-- FOTO --}}
                <div class="col-span-2">
                    <label class="block text-slate-500 mb-2">Foto Profil</label>

                    @if($user->foto)
                        <img src="{{ asset('storage/'.$user->foto) }}"
                             class="h-32 rounded-lg border mb-3">
                    @endif

                    <input x-show="editMode" type="file" name="foto"
                        class="w-full px-4 py-2 border rounded-lg bg-white file:mr-3 file:px-3 file:py-1 file:border-0 file:bg-slate-200 file:rounded">
                </div>

            </div>

            {{-- BUTTON SAVE --}}
            <div x-show="editMode" x-transition class="mt-6 flex justify-end border-t pt-4">
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection