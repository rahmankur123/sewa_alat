@extends('layouts.app')
@section('title','Edit Profil')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h2 class="text-3xl font-bold tracking-tight text-slate-800">
            Edit Profil
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Kelola informasi akun dan data profil Anda
        </p>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 shadow-sm">

        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100">
            ✅
        </div>

        <div class="text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>

    </div>
    @endif

    {{-- ERROR --}}
    @if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">

        <div class="flex items-start gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                ⚠️
            </div>

            <div>

                <h4 class="text-sm font-semibold text-red-700 mb-2">
                    Terjadi kesalahan:
                </h4>

                <ul class="list-disc pl-5 space-y-1 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        </div>

    </div>
    @endif

    {{-- CARD --}}
    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">

        <form action="{{ route('anggota.profil.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="p-8">

                {{-- FOTO --}}
                <div class="flex flex-col items-center mb-10">

                    <div class="relative">

                        <img id="preview"
                            src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('img/default.png') }}"
                            class="w-36 h-36 object-cover rounded-full border-4 border-white shadow-lg">

                    </div>

                    <div class="mt-5">

                        <label class="cursor-pointer">

                            <span class="inline-flex items-center gap-2 rounded-2xl bg-slate-100 px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-200 transition">
                                📷 Upload Foto
                            </span>

                            <input type="file"
                                   name="foto"
                                   class="hidden"
                                   onchange="previewImage(event)">

                        </label>

                    </div>

                </div>

                {{-- FORM --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- NAMA --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-600">
                            Nama
                        </label>

                        <input type="text"
                            name="name"
                            value="{{ old('name',$user->name) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 transition">

                    </div>

                    {{-- EMAIL --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-600">
                            Email
                        </label>

                        <input type="email"
                            name="email"
                            value="{{ old('email',$user->email) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 transition">

                    </div>

                    {{-- NO HP --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-600">
                            No HP
                        </label>

                        <input type="text"
                            name="no_hp"
                            value="{{ old('no_hp',$user->no_hp) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 transition">

                    </div>

                    {{-- PASSWORD --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-600">
                            Password Baru
                        </label>

                        <input type="password"
                            name="password"
                            placeholder="Kosongkan jika tidak diganti"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 transition">

                    </div>

                    {{-- ALAMAT --}}
                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-slate-600">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            rows="4"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 transition">{{ old('alamat',$user->alamat) }}</textarea>

                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-slate-600">
                            Konfirmasi Password
                        </label>

                        <input type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password baru"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 transition">

                    </div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="border-t border-slate-100 bg-slate-50 px-8 py-5">

                <div class="flex justify-end">

                    <button type="submit"
                        onclick="this.disabled=true; this.innerText='Menyimpan...'; this.form.submit();"
                        class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 hover:shadow-md transition duration-200">

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- PREVIEW FOTO --}}
<script>
function previewImage(e){
    const reader = new FileReader();

    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }

    reader.readAsDataURL(e.target.files[0]);
}
</script>

@endsection