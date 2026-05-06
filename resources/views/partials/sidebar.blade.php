@php
    $role = auth()->user()->role ?? null;
@endphp

<aside class="w-64 h-screen bg-white border-r flex flex-col shadow-sm">

    <!-- HEADER -->
    <div class="px-6 py-5 border-b">
        <h2 class="text-lg font-semibold text-gray-800">
            Dashboard
        </h2>
        <p class="text-xs text-gray-500 mt-1 capitalize">
            {{ $role }}
        </p>
    </div>

    <!-- MENU -->
    <nav class="flex-1 overflow-y-auto px-4 py-4 text-sm space-y-1">

        {{-- STYLE BASE --}}
        @php
            $menuClass = "flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition";
            $activeClass = "bg-indigo-100 text-indigo-600 font-semibold";
        @endphp


        <!-- PEMILIK -->
        @if($role == 'pemilik')

        <a href="/admin/dashboard" class="{{ $menuClass }}">
            🏠 Home
        </a>

        <p class="text-xs text-gray-400 mt-4 mb-2 uppercase">Management</p>

        <a href="/laporan" class="{{ $menuClass }}">
            📊 Laporan
        </a>

        <a href="/petugas" class="{{ $menuClass }}">
            👨‍💼 Petugas
        </a>

        @endif


        <!-- PETUGAS -->
        @if($role == 'petugas')

        <a href="/petugas/dashboard" class="{{ $menuClass }}">
            🏠 Home
        </a>

        <p class="text-xs text-gray-400 mt-4 mb-2 uppercase">Master Data</p>

        <a href="/petugas/barang" class="{{ $menuClass }}">
            📦 Barang
        </a>

        <a href="/petugas/user" class="{{ $menuClass }}">
            👥 Anggota
        </a>

        <!-- TRANSAKSI -->
        <div x-data="{open:false}">
            <button @click="open=!open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">

                <span class="flex items-center gap-3">
                    🧾 Transaksi
                </span>

                <svg :class="open ? 'rotate-180' : ''"
                    class="w-4 h-4 transition-transform"
                    fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-gray-600">

                <a href="/petugas/transaksi/create" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    💰 Kasir
                </a>

                <a href="/petugas/transaksi/tersewa" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📦 Tersewa
                </a>

                <a href="/petugas/transaksi/dipinjam" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📤 Dipinjam
                </a>

                <a href="/petugas/transaksi/terdenda" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    ⚠️ Denda
                </a>

                <a href="/petugas/transaksi/hilang" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📦 Barang Hilang
                </a>

                <a href="/petugas/transaksi/selesai" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    ✅ Selesai
                </a>

            </div>
        </div>

        <!-- LAPORAN -->
        <div x-data="{open:false}">
            <button @click="open=!open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">

                <span class="flex items-center gap-3">
                    📑 Laporan
                </span>

                <svg :class="open ? 'rotate-180' : ''"
                    class="w-4 h-4 transition-transform"
                    fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-gray-600">

                <a href="/petugas/laporan" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    💰 Denda
                </a>

                <a href="/petugas/laporan" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📦 Kerusakan
                </a>

                <a href="/petugas/laporan" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📤 Penyewaan
                </a>

            </div>
        </div>

        @endif


        <!-- ANGGOTA -->
        @if($role == 'anggota')

        <a href="/anggota/dashboard" class="{{ $menuClass }}">
            🏠 Home
        </a>

        <p class="text-xs text-gray-400 mt-4 mb-2 uppercase">Menu</p>

        <a href="/anggota/sewa" class="{{ $menuClass }}">
            🛒 Katalog
        </a>

        <div x-data="{open:false}">
            <button @click="open=!open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">

                <span class="flex items-center gap-3">
                    🧾 Transaksi
                </span>

                <svg :class="open ? 'rotate-180' : ''"
                    class="w-4 h-4 transition-transform"
                    fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-gray-600">

                <a href="/anggota/riwayat/tersewa" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📦 Tersewa
                </a>

                <a href="/anggota/riwayat/dipinjam" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📤 Dipinjam
                </a>

                <a href="/anggota/riwayat/terdenda" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    ⚠️ Denda
                </a>

                <a href="/anggota/riwayat/hilang" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    📦 Barang Hilang
                </a>

                <a href="/anggota/riwayat/selesai" class="block px-3 py-2 rounded-lg hover:bg-indigo-50">
                    ✅ Selesai
                </a>

            </div>
        </div>

        <a href="/anggota/profile" class="{{ $menuClass }}">
            👤 Profile
        </a>

        @endif

    </nav>

</aside>