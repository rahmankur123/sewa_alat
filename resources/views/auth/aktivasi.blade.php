<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aktivasi Akun</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN (biar langsung jalan) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg">

    <h2 class="text-2xl font-bold text-center text-slate-700 mb-6">
        Aktivasi Akun
    </h2>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-600 p-3 rounded text-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST">
        @csrf

        <div class="mb-3">
            <input type="text" name="name" placeholder="Nama Lengkap"
                value="{{ old('name') }}"
                class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <div class="mb-3">
            <input type="text" name="alamat" placeholder="Alamat"
                value="{{ old('alamat') }}"
                class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <div class="mb-3">
            <input type="password" name="password" placeholder="Password"
                class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <div class="mb-4">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Aktivasi Akun
        </button>
    </form>

</div>

</body>
</html>