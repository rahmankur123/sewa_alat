@php
    $role = auth()->user()->role ?? null;
@endphp

<aside class="w-64 min-h-screen bg-indigo-700 text-white shadow-lg">
    
    <div class="p-5 border-b border-indigo-500">
        <h2 class="text-2xl font-bold">Dashboard</h2>
    </div>

    <ul class="p-4 space-y-2">

        {{-- HOME --}}
        <li>
            <a href="/dashboard"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>🏠</span> Home
            </a>
        </li>

        {{-- PEMILIK --}}
        @if($role == 'pemilik')
        <li>
            <a href="/laporan"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>📊</span> Laporan
            </a>
        </li>

        <li>
            <a href="/petugas"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>👨‍💼</span> Data Petugas
            </a>
        </li>
        @endif


        {{-- PETUGAS --}}
        @if($role == 'petugas')

        <li>
            <a href="/petugas/barang"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>📦</span> Barang
            </a>
        </li>

        <li>
            <a href="/petugas/user"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>👥</span> Anggota
            </a>
        </li>

        {{-- DROPDOWN TRANSAKSI --}}
        <li x-data="{open:false}">
            
            <button 
                @click="open=!open"
                class="w-full flex justify-between items-center p-2 rounded hover:bg-indigo-600 transition">
                
                <span class="flex items-center gap-3">
                    🧾 Transaksi
                </span>

                <span x-text="open ? '▲' : '▼'"></span>
            </button>

            <ul x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-sm">

                <li>
                    <a href="/petugas/transaksi/create"
                       class="block p-2 rounded hover:bg-indigo-600">
                       💰 Kasir
                    </a>
                </li>

                <li>
                    <a href="/petugas/transaksi/tersewa"
                       class="block p-2 rounded hover:bg-indigo-600">
                       📦 Tersewa
                    </a>
                </li>

                <li>
                    <a href="/petugas/transaksi/dipinjam"
                       class="block p-2 rounded hover:bg-indigo-600">
                       📤 Dipinjam
                    </a>
                </li>

                <li>
                    <a href="/petugas/transaksi/terdenda"
                       class="block p-2 rounded hover:bg-indigo-600">
                       ⚠️ Denda
                    </a>
                </li>

                <li>
                    <a href="/petugas/transaksi/selesai"
                       class="block p-2 rounded hover:bg-indigo-600">
                       ✅ Selesai
                    </a>
                </li>

            </ul>

        </li>
        <li>
            <a href="/katalog"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>🛒</span> Anggota Sewa
            </a>
        </li>

        <li>
            <a href="/riwayat"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>📜</span> Riwayat Sewa
            </a>
        </li>
        <li x-data="{open:false}">
            
            <button 
                @click="open=!open"
                class="w-full flex justify-between items-center p-2 rounded hover:bg-indigo-600 transition">
                
                <span class="flex items-center gap-3">
                    🧾 Laporan
                </span>

                <span x-text="open ? '▲' : '▼'"></span>
            </button>

            <ul x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-sm">

                <li>
                    <a href="/petugas/transaksi/create"
                       class="block p-2 rounded hover:bg-indigo-600">
                       💰 Laporan Denda
                    </a>
                </li>

                <li>
                    <a href="/petugas/transaksi/tersewa"
                       class="block p-2 rounded hover:bg-indigo-600">
                       📦 Laporan Kerusakan
                    </a>
                </li>

                <li>
                    <a href="/petugas/transaksi/dipinjam"
                       class="block p-2 rounded hover:bg-indigo-600">
                       📤 Laporan Penyewaan
                    </a>
                </li>

            </ul>

        </li>

        @endif


        {{-- ANGGOTA --}}
        @if($role == 'anggota')

        <li>
            <a href="/katalog"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>🛒</span> Katalog Sewa
            </a>
        </li>

        <li>
            <a href="/riwayat"
               class="flex items-center gap-3 p-2 rounded hover:bg-indigo-600 transition">
                <span>📜</span> Riwayat Sewa
            </a>
        </li>

        @endif

    </ul>

</aside>