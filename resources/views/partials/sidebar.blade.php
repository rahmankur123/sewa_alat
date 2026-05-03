@php
    $role = auth()->user()->role ?? null;
@endphp

<aside class="w-64 h-screen bg-slate-900 text-slate-200 flex flex-col shadow-xl">

    <!-- HEADER -->
    <div class="px-6 py-5 border-b border-slate-800">
        <h2 class="text-lg font-semibold tracking-wide text-white">
            Dashboard
        </h2>
        <p class="text-xs text-slate-400 mt-1 capitalize">
            {{ $role }}
        </p>
    </div>

    <!-- MENU -->
    <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1 text-sm">

        <!-- HOME -->
        <a href="/dashboard"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            <span>🏠</span>
            <span>Home</span>
        </a>

        <!-- PEMILIK -->
        @if($role == 'pemilik')

        <p class="text-xs text-slate-500 mt-4 mb-2 uppercase">Management</p>

        <a href="/laporan"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            <span>📊</span>
            <span>Laporan</span>
        </a>

        <a href="/petugas"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            <span>👨‍💼</span>
            <span>Petugas</span>
        </a>

        @endif


        <!-- PETUGAS -->
        @if($role == 'petugas')

        <p class="text-xs text-slate-500 mt-4 mb-2 uppercase">Master Data</p>

        <a href="/petugas/barang"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            <span>📦</span>
            <span>Barang</span>
        </a>

        <a href="/petugas/user"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            <span>👥</span>
            <span>Anggota</span>
        </a>

        <!-- TRANSAKSI -->
        <div x-data="{open:false}">
            <button @click="open=!open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-800 transition">
                
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

            <div x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-sm">

                <a href="/petugas/transaksi/create" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    💰 Kasir
                </a>

                <a href="/petugas/transaksi/tersewa" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    📦 Tersewa
                </a>

                <a href="/petugas/transaksi/dipinjam" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    📤 Dipinjam
                </a>

                <a href="/petugas/transaksi/terdenda" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    ⚠️ Denda
                </a>

                <a href="/petugas/transaksi/selesai" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    ✅ Selesai
                </a>

            </div>
        </div>

        <!-- LAPORAN -->
        <div x-data="{open:false}">
            <button @click="open=!open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-800 transition">
                
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

            <div x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-sm">

                <a href="#" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    💰 Denda
                </a>

                <a href="#" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    📦 Kerusakan
                </a>

                <a href="#" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    📤 Penyewaan
                </a>

            </div>
        </div>

        @endif


        <!-- ANGGOTA -->
        @if($role == 'anggota')

        <p class="text-xs text-slate-500 mt-4 mb-2 uppercase">Menu</p>

        <a href="/anggota/sewa"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
            <span>🛒</span>
            <span>Katalog</span>
        </a>

        <div x-data="{open:false}">
            <button @click="open=!open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-800 transition">
                
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

            <div x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-sm">

                <a href="/anggota/riwayat/tersewa" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    📦 Tersewa
                </a>

                <a href="/anggota/riwayat/dipinjam" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    📤 Dipinjam
                </a>

                <a href="/anggota/riwayat/terdenda" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    ⚠️ Denda
                </a>

                <a href="/anggota/riwayat/selesai" class="block px-3 py-2 rounded-lg hover:bg-slate-800">
                    ✅ Selesai
                </a>

            </div>
        </div>
        
            <a href="/anggota/profile"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
                <span>👤</span>
                <span>Profile</span>
            </a>

        @endif

    </nav>

</aside>