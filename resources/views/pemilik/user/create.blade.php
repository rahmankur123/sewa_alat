@extends('layouts.app')

@section('title','Tambah Petugas')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-slate-700">
            Tambah Petugas
        </h2>

        <a href="{{ route('pemilik.user.index') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
            ← Kembali
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pemilik.user.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- DATA UTAMA --}}
            <div>
                <h3 class="text-xs font-semibold text-slate-500 mb-3 uppercase tracking-wide">
                    Data Utama
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none"
                            required>
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none"
                            required>
                    </div>

                    {{-- NO HP --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">No Telepon</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none"
                            required>
                    </div>

                </div>
            </div>

            {{-- ALAMAT --}}
            <div>
                <h3 class="text-xs font-semibold text-slate-500 mb-3 uppercase tracking-wide">
                    Informasi Tambahan
                </h3>

                <textarea name="alamat" rows="3"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none"
                    placeholder="Masukkan alamat...">{{ old('alamat') }}</textarea>
            </div>

            {{-- PASSWORD --}}
            <div>
                <h3 class="text-xs font-semibold text-slate-500 mb-3 uppercase tracking-wide">
                    Keamanan
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    {{-- PASSWORD --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none"
                                required>
                            <span onclick="togglePassword('password')" 
                                  class="absolute right-3 top-2.5 cursor-pointer text-slate-400 text-sm">
                                👁
                            </span>
                        </div>
                    </div>

                    {{-- KONFIRMASI --}}
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none"
                                required>
                            <span onclick="togglePassword('password_confirmation')" 
                                  class="absolute right-3 top-2.5 cursor-pointer text-slate-400 text-sm">
                                👁
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- FOTO --}}
            <div>
                <h3 class="text-xs font-semibold text-slate-500 mb-3 uppercase tracking-wide">
                    Foto Profil
                </h3>

                <input type="file" name="foto" id="fotoInput"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm bg-white">

                {{-- PREVIEW --}}
                <img id="previewFoto" class="mt-3 w-24 h-24 object-cover rounded-lg hidden border">
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-2 pt-4 ">

                <a href="{{ route('petugas.user.index') }}"
                   class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 text-sm">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white cursor-pointer rounded-lg hover:bg-blue-700 transition text-sm">
                    Simpan Petugas
                </button>

            </div>

        </form>

    </div>

</div>

{{-- SCRIPT --}}
<script>
function togglePassword(id){
    let input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

document.getElementById('fotoInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const preview = document.getElementById('previewFoto');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection