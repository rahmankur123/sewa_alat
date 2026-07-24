<header class="h-full bg-white px-4 md:px-6 flex items-center justify-between">

    {{-- LEFT --}}
    <div class="flex items-center gap-4">

        {{-- MOBILE BUTTON --}}
        <button
            @click="open = true"
            class="md:hidden w-10 h-10 rounded-lg hover:bg-slate-100 text-gray-700"
        >
            ☰
        </button>

        {{-- LOGO --}}
        <div class="flex items-center gap-3">

            <img
                src="{{ asset('/storage/logo.jpg') }}"
                class="w-10 h-10 rounded-xl object-cover border"
            >

            <div class="hidden sm:block">
                <h1 class="font-bold text-gray-800 leading-tight">
                    Sistem Persewaan
                </h1>

                <p class="text-xs text-gray-500">
                    Alat Bela Diri
                </p>
            </div>

        </div>

    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-4">

        {{-- USER --}}
        <div class="hidden sm:block text-right">

            <h3 class="text-sm font-semibold text-gray-800">
                {{ auth()->user()->name }}
            </h3>

            <p class="text-xs text-gray-500 capitalize">
                {{ auth()->user()->role }}
            </p>

        </div>

        {{-- FOTO --}}
        <img src="{{ asset('storage/' . auth()->user()->foto) }}"
             class="w-10 h-10 rounded-full object-cover border">

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                class="bg-blue-600 cursor-pointer hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition"
            >
                Logout
            </button>

        </form>

    </div>

</header>