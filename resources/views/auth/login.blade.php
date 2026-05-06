<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Rental</title>
    <link rel="stylesheet" href="{{ asset('public/build/assets/app.css') }}">
</head>

<body class="bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md px-4">

    <div class="bg-white shadow-xl rounded-2xl p-8 border border-slate-200">

        {{-- HEADER --}}
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-700">
                Login Sistem Rental
            </h2>
            <p class="text-sm text-slate-400">
                Silakan masuk ke akun Anda
            </p>
        </div>

        {{-- ERROR --}}
        @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm border border-red-300">
            {{ session('error') }}
        </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('login.proses') }}" class="space-y-4">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm text-slate-600 mb-1">Email</label>
                <input 
                    type="email" 
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm 
                           focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Masukkan email"
                    required
                >
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-sm text-slate-600 mb-1">Password</label>
                <input 
                    type="password" 
                    name="password"
                    class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm 
                           focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            {{-- BUTTON --}}
            <button 
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm font-semibold"
            >
                Login
            </button>

        </form>

    </div>

    {{-- FOOTER --}}
    <p class="text-center text-xs text-slate-400 mt-4">
        © {{ date('Y') }} Sistem Rental
    </p>

</div>

</body>
</html>