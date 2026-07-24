<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Rental</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-200 to-slate-300">

<div class="min-h-screen flex items-center justify-center p-4 md:p-6">

    {{-- CARD LEBIH KECIL --}}
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

        {{-- ===================================== --}}
        {{-- LEFT SIDE --}}
        {{-- ===================================== --}}
        <div class="bg-white p-8 md:p-10 flex flex-col justify-center">

            {{-- HEADER --}}
            <div class="mb-6">
                <h2 class="text-3xl font-extrabold text-slate-800">
                    Login
                </h2>

                <p class="text-slate-500 mt-2 text-sm">
                    Selamat datang kembali di sistem penyewaan alat bela diri.
                </p>
            </div>

            {{-- ERROR --}}
            @if(session('error'))
            <div class="mb-5 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-2xl text-sm">
                {{ session('error') }}
            </div>
            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('login.proses') }}" class="space-y-4">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-5 py-3 text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition"
                    >
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-5 py-3 text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition"
                    >
                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-2xl font-bold transition duration-300 shadow-lg cursor-pointer hover:shadow-xl"
                >
                    Login Sekarang
                </button>
            </form>

            {{-- FOOTER --}}
            <div class="mt-6 text-xs text-slate-400">
                © {{ date('Y') }} Sistem Rental Alat Bela Diri
            </div>

        </div>


        {{-- ===================================== --}}
        {{-- RIGHT SIDE --}}
        {{-- ===================================== --}}
<div class="hidden lg:flex relative bg-gradient-to-br from-blue-700 via-indigo-700 to-slate-900 text-white px-8 py-7 flex-col justify-center overflow-hidden">
            {{-- BACKGROUND EFFECT --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-52 h-52 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-cyan-300 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10">

    {{-- LOGO --}}
    <div class="mb-5 flex justify-center">
        <div class="w-16 h-16 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20 shadow-lg">
            <img
                src="{{ asset('/storage/logo.jpg') }}"
                alt="Logo"
                class="w-11 h-11 object-contain"
            >
        </div>
    </div>

    {{-- TITLE --}}
    <h1 class="text-3xl font-extrabold leading-tight mb-3 text-center">
        BLACK <br>
        DRAGGER CAMP
    </h1>

    {{-- DESC --}}
    <p class="text-blue-100 leading-relaxed text-sm text-center max-w-sm mx-auto">
        Sistem penyewaan alat bela diri modern untuk membantu pengelolaan transaksi,
        stok barang, dan laporan secara cepat dan efisien.
    </p>

    {{-- FEATURES --}}
    <div class="mt-7 space-y-3">

        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-base shrink-0">
                📦
            </div>

            <div>
                <h3 class="font-semibold text-sm">
                    Manajemen Barang
                </h3>

                <p class="text-xs text-blue-100">
                    Kelola stok alat bela diri.
                </p>
            </div>
        </div>

        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-base shrink-0">
                🧾
            </div>

            <div>
                <h3 class="font-semibold text-sm">
                    Transaksi Cepat
                </h3>

                <p class="text-xs text-blue-100">
                    Penyewaan lebih praktis.
                </p>
            </div>
        </div>

        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-base shrink-0">
                📊
            </div>

            <div>
                <h3 class="font-semibold text-sm">
                    Laporan Otomatis
                </h3>

                <p class="text-xs text-blue-100">
                    Monitoring data lebih akurat.
                </p>
            </div>
        </div>

    </div>

</div>

        </div>

    </div>

</div>

</body>
</html>