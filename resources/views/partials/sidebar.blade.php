@php
    $role = auth()->user()->role ?? null;

    $menuClass = "flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200";
    $inactiveClass = "text-blue-100 hover:bg-white/10 hover:text-white";
    $activeClass = "bg-white text-blue-600 font-semibold shadow";

    function activeMenu($paths = []) {
        foreach ($paths as $path) {
            if (request()->is($path)) {
                return true;
            }
        }
        return false;
    }
@endphp

<div class="h-full flex flex-col">

    {{-- LOGO --}}
    <div class="h-16 px-6 flex items-center border-b border-white/10">
        <div>
            <h1 class="text-xl font-bold tracking-wide">
                BELADIRI RENT
            </h1>

            <p class="text-xs text-blue-100 mt-1 capitalize">
                {{ $role }}
            </p>
        </div>
    </div>

    {{-- MENU --}}
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-2 text-sm">

        {{-- ================= PEMILIK ================= --}}
        @if($role == 'pemilik')

            <a href="/pemilik/dashboard"
               class="{{ $menuClass }} {{ activeMenu(['pemilik/dashboard']) ? $activeClass : $inactiveClass }}">
                🏠 Dashboard
            </a>

            <div class="pt-4">
                <p class="text-xs uppercase tracking-widest text-blue-200 mb-3">
                    Laporan
                </p>

                <div class="space-y-1 border-l border-white/20 ml-3 pl-4">

                    <a href="/pemilik/laporan/barang-hilang"
                       class="{{ activeMenu(['pemilik/laporan/barang-hilang']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Barang Hilang
                    </a>

                    <a href="/pemilik/laporan/kerusakan"
                       class="block py-1 {{ activeMenu(['pemilik/laporan/kerusakan']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Kerusakan
                    </a>

                    <a href="/pemilik/laporan/penyewaan"
                       class="block py-1 {{ activeMenu(['pemilik/laporan/penyewaan']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Penyewaan
                    </a>

                </div>
            </div>

        @endif


        {{-- ================= PETUGAS ================= --}}
        @if($role == 'petugas')

            <a href="/petugas/dashboard"
               class="{{ $menuClass }} {{ activeMenu(['petugas/dashboard']) ? $activeClass : $inactiveClass }}">
                🏠 Dashboard
            </a>

            <div class="pt-4">
                <p class="text-xs uppercase tracking-widest text-blue-200 mb-3">
                    Master Data
                </p>

                <div class="space-y-2">

                    <a href="/petugas/barang"
                       class="{{ $menuClass }} {{ activeMenu(['petugas/barang*']) ? $activeClass : $inactiveClass }}">
                        📦 Barang
                    </a>

                    <a href="/petugas/user"
                       class="{{ $menuClass }} {{ activeMenu(['petugas/user*']) ? $activeClass : $inactiveClass }}">
                        👥 Anggota
                    </a>

                </div>
            </div>

            {{-- TRANSAKSI --}}
            <div class="pt-4" x-data="{ open: false }">

                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-blue-100 hover:bg-white/10"
                >
                    <span>🧾 Transaksi</span>

                    <svg
                        :class="open ? 'rotate-180' : ''"
                        class="w-4 h-4 transition"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition class="mt-2 ml-3 border-l border-white/20 pl-4 space-y-1">

                    <a href="/petugas/transaksi/create"
                       class="block py-1 {{ activeMenu(['petugas/transaksi/create']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Kasir
                    </a>

                    <a href="/petugas/transaksi/tersewa"
                       class="block py-1 {{ activeMenu(['petugas/transaksi/tersewa']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Tersewa
                    </a>

                    <a href="/petugas/transaksi/dipinjam"
                       class="block py-1 {{ activeMenu(['petugas/transaksi/dipinjam']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Dipinjam
                    </a>

                    <a href="/petugas/transaksi/terdenda"
                       class="block py-1 {{ activeMenu(['petugas/transaksi/terdenda']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Denda
                    </a>

                    <a href="/petugas/transaksi/hilang"
                       class="block py-1 {{ activeMenu(['petugas/transaksi/hilang']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Barang Hilang
                    </a>

                    <a href="/petugas/transaksi/selesai"
                       class="block py-1 {{ activeMenu(['petugas/transaksi/selesai']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Selesai
                    </a>

                </div>
            </div>

            {{-- LAPORAN --}}
            <div class="pt-4">

                <p class="text-xs uppercase tracking-widest text-blue-200 mb-3">
                    Laporan
                </p>

                <div class="space-y-1 border-l border-white/20 ml-3 pl-4">

                    <a href="/petugas/laporan/barang-hilang"
                       class="block py-1 {{ activeMenu(['petugas/laporan/barang-hilang']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Barang Hilang
                    </a>

                    <a href="/petugas/laporan/kerusakan"
                       class="block py-1 {{ activeMenu(['petugas/laporan/kerusakan']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Kerusakan
                    </a>

                    <a href="/petugas/laporan/penyewaan"
                       class="block py-1 {{ activeMenu(['petugas/laporan/penyewaan']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Penyewaan
                    </a>

                </div>

            </div>

        @endif


        {{-- ================= ANGGOTA ================= --}}
        @if($role == 'anggota')

            <a href="/anggota/dashboard"
               class="{{ $menuClass }} {{ activeMenu(['anggota/dashboard']) ? $activeClass : $inactiveClass }}">
                🏠 Dashboard
            </a>

            <a href="/anggota/sewa"
               class="{{ $menuClass }} {{ activeMenu(['anggota/sewa*']) ? $activeClass : $inactiveClass }}">
                🛒 Katalog
            </a>

            {{-- TRANSAKSI --}}
            <div class="pt-4" x-data="{ open: true }">

                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-blue-100 hover:bg-white/10"
                >
                    <span>🧾 Transaksi</span>

                    <svg
                        :class="open ? 'rotate-180' : ''"
                        class="w-4 h-4 transition"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition class="mt-2 ml-3 border-l border-white/20 pl-4 space-y-1">

                    <a href="/anggota/riwayat/tersewa"
                       class="block py-1 {{ activeMenu(['anggota/riwayat/tersewa']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Tersewa
                    </a>

                    <a href="/anggota/riwayat/dipinjam"
                       class="block py-1 {{ activeMenu(['anggota/riwayat/dipinjam']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Dipinjam
                    </a>

                    <a href="/anggota/riwayat/terdenda"
                       class="block py-1 {{ activeMenu(['anggota/riwayat/terdenda']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Denda
                    </a>

                    <a href="/anggota/riwayat/hilang"
                       class="block py-1 {{ activeMenu(['anggota/riwayat/hilang']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Barang Hilang
                    </a>

                    <a href="/anggota/riwayat/selesai"
                       class="block py-1 {{ activeMenu(['anggota/riwayat/selesai']) ? 'text-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Selesai
                    </a>

                </div>
            </div>

            <a href="/anggota/profil"
               class="{{ $menuClass }} {{ activeMenu(['anggota/profil']) ? $activeClass : $inactiveClass }}">
                👤 Profil
            </a>

        @endif

    </div>

</div>