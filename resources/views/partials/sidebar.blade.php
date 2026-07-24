@php
    $role = auth()->user()->role ?? null;

    $menuClass = "flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-semibold text-[15px]";
    $inactiveClass = "text-blue-100 hover:bg-white/10 hover:text-white";
    $activeClass = "bg-white text-blue-700 font-bold shadow-lg";

    function activeMenu($paths = []) {
        foreach ($paths as $path) {
            if (request()->is($path)) {
                return true;
            }
        }
        return false;
    }
@endphp

<div class="h-full flex flex-col mt-5 bg-gradient-to-b from-blue-500 to-blue-900 text-white">

    {{-- LOGO --}}
    <div class="h-20 px-6 flex items-center border-b border-white/10">

        <div>
            <h1 class="text-2xl font-extrabold tracking-wide leading-tight">
                BLACK DRAGGER CAMP
            </h1>

            <p class="text-sm text-blue-100 mt-1 capitalize font-medium">
                {{ $role }}
            </p>
        </div>

    </div>

    {{-- MENU --}}
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-2">

        {{-- ================= PEMILIK ================= --}}
        @if($role == 'pemilik')

            <a href="/pemilik/dashboard"
               class="{{ $menuClass }} {{ activeMenu(['pemilik/dashboard']) ? $activeClass : $inactiveClass }}">
                <span class="text-lg">🏠</span>
                Dashboard
            </a>

            <a href="/pemilik/user"
               class="{{ $menuClass }} {{ activeMenu(['pemilik/user*']) ? $activeClass : $inactiveClass }}">
                <span class="text-lg">👥</span>
                Petugas
            </a>

            <div class="pt-3">

                <p class="text-xs uppercase tracking-[3px] text-blue-200 mb-3 font-bold">
                    Laporan
                </p>

                <div class="space-y-2 border-l border-white/20 ml-3 pl-4">

                    <a href="/pemilik/laporan/barang-hilang"
                       class="block py-2 font-semibold text-[15px] {{ activeMenu(['pemilik/laporan/barang-hilang']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Barang Hilang
                    </a>

                    <a href="/pemilik/laporan/kerusakan"
                       class="block py-2 font-semibold text-[15px] {{ activeMenu(['pemilik/laporan/kerusakan']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Kerusakan
                    </a>

                    <a href="/pemilik/laporan/penyewaan"
                       class="block py-2 font-semibold text-[15px] {{ activeMenu(['pemilik/laporan/penyewaan']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Penyewaan
                    </a>

                </div>

            </div>

        @endif


        {{-- ================= PETUGAS ================= --}}
        @if($role == 'petugas')

            <a href="/petugas/dashboard"
               class="{{ $menuClass }} {{ activeMenu(['petugas/dashboard']) ? $activeClass : $inactiveClass }}">
                <span class="text-lg">🏠</span>
                Dashboard
            </a>

            {{-- MASTER DATA --}}
            <div class="pt-3">

                <p class="text-xs uppercase tracking-[3px] text-blue-200 mb-3 font-bold">
                    Master Data
                </p>

                <div class="space-y-2">

                    <a href="/petugas/barang"
                       class="{{ $menuClass }} {{ activeMenu(['petugas/barang*']) ? $activeClass : $inactiveClass }}">
                        <span class="text-lg">📦</span>
                        Barang
                    </a>

                    <a href="/petugas/user"
                       class="{{ $menuClass }} {{ activeMenu(['petugas/user*']) ? $activeClass : $inactiveClass }}">
                        <span class="text-lg">👥</span>
                        Anggota
                    </a>

                </div>

            </div>

            {{-- TRANSAKSI --}}
            <div class="pt-3"
                 x-data="{ open: {{ activeMenu([
                    'petugas/transaksi/create',
                    'petugas/transaksi/tersewa',
                    'petugas/transaksi/dipinjam',
                    'petugas/transaksi/terdenda',
                    'petugas/transaksi/selesai'
                 ]) ? 'true' : 'false' }} }">

                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-bold text-[15px] text-blue-100 hover:bg-white/10 hover:text-white transition"
                >
                    <div class="flex items-center cursor-pointer gap-3">
                        <span class="text-lg">🧾</span>
                        <span>Transaksi</span>
                    </div>

                    <svg
                        :class="open ? 'rotate-180' : ''"
                        class="w-4 h-4 transition duration-300"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open"
                     x-transition
                     class="mt-2 ml-4 border-l border-white/20 pl-4 space-y-2">

                    <a href="/petugas/transaksi/create"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/transaksi/create']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Kasir
                    </a>

                    <a href="/petugas/transaksi/tersewa"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/transaksi/tersewa']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Tersewa
                    </a>

                    <a href="/petugas/transaksi/dipinjam"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/transaksi/dipinjam']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Dipinjam
                    </a>

                    <a href="/petugas/transaksi/terdenda"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/transaksi/terdenda']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Denda
                    </a>

                    <a href="/petugas/transaksi/selesai"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/transaksi/selesai']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Selesai
                    </a>

                </div>

            </div>

            {{-- LAPORAN --}}
            <div class="pt-3">

                <p class="text-xs uppercase tracking-[3px] text-blue-200 mb-3 font-bold">
                    Laporan
                </p>

                <div class="space-y-2 border-l border-white/20 ml-3 pl-4">

                    <a href="/petugas/laporan/barang-hilang"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/laporan/barang-hilang']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Barang Hilang
                    </a>

                    <a href="/petugas/laporan/kerusakan"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/laporan/kerusakan']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Kerusakan
                    </a>

                    <a href="/petugas/laporan/penyewaan"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['petugas/laporan/penyewaan']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Penyewaan
                    </a>

                </div>

            </div>

        @endif


        {{-- ================= ANGGOTA ================= --}}
        @if($role == 'anggota')

            <a href="/anggota/dashboard"
               class="{{ $menuClass }} {{ activeMenu(['anggota/dashboard']) ? $activeClass : $inactiveClass }}">
                <span class="text-lg">🏠</span>
                Dashboard
            </a>

            <a href="/anggota/sewa"
               class="{{ $menuClass }} {{ activeMenu(['anggota/sewa*']) ? $activeClass : $inactiveClass }}">
                <span class="text-lg">🛒</span>
                Katalog
            </a>

            {{-- TRANSAKSI --}}
            <div class="pt-5"
                 x-data="{ open: true }">

                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-bold text-[15px] text-blue-100 hover:bg-white/10 hover:text-white transition"
                >
                    <div class="flex items-center gap-3">
                        <span class="text-lg">🧾</span>
                        <span>Transaksi</span>
                    </div>

                    <svg
                        :class="open ? 'rotate-180' : ''"
                        class="w-4 h-4 transition duration-300"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open"
                     x-transition
                     class="mt-2 ml-4 border-l border-white/20 pl-4 space-y-2">

                    <a href="/anggota/riwayat/tersewa"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['anggota/riwayat/tersewa']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Tersewa
                    </a>

                    <a href="/anggota/riwayat/dipinjam"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['anggota/riwayat/dipinjam']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Dipinjam
                    </a>

                    <a href="/anggota/riwayat/terdenda"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['anggota/riwayat/terdenda']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Denda
                    </a>

                    <a href="/anggota/riwayat/selesai"
                       class="block py-2 text-[15px] font-semibold {{ activeMenu(['anggota/riwayat/selesai']) ? 'text-white font-bold' : 'text-blue-100 hover:text-white' }}">
                        Selesai
                    </a>

                </div>

            </div>

            <a href="/anggota/profil"
               class="{{ $menuClass }} {{ activeMenu(['anggota/profil']) ? $activeClass : $inactiveClass }}">
                <span class="text-lg">👤</span>
                Profil
            </a>

        @endif

    </div>

</div>