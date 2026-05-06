<header class="bg-white border-b px-4 md:px-6 w-full py-3 flex justify-between items-center">

    {{-- LEFT --}}
    <div class="flex items-center gap-3">
        <img 
            src="{{ asset('/storage/logo.jpg') }}" 
            class="w-9 h-9 object-contain"
        >
        <h1 class="font-semibold text-gray-800 text-lg hidden sm:block">
            Sistem Persewaan
        </h1>
    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-3">

        {{-- USER --}}
        <div class="text-right hidden sm:block">
            <p class="text-sm font-semibold text-gray-800">
                {{ auth()->user()->name }}
            </p>
            <p class="text-xs text-gray-500 capitalize">
                {{ auth()->user()->role }}
            </p>
        </div>

        {{-- FOTO --}}
        <img 
            src="{{ asset('/storage/user/' . auth()->user()->foto) }}"
            class="w-9 h-9 object-cover rounded-full border"
        >

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 text-sm rounded-lg transition">
                Logout
            </button>
        </form>

    </div>

</header>