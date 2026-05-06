<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Sewa Alat Bela Diri</title>

    @vite('resources/css/app.css')

    <style>
    @media print {
        body {
            background: white !important;
        }

        aside, header, footer {
            display: none !important;
        }

        .no-print {
            display: none !important;
        }

        main {
            padding: 0 !important;
        }
    }
    </style>
</head>

<body class="bg-gray-100">

<div x-data="{ open: false }" class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside 
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed md:static z-40 w-64 bg-white shadow-md transform md:translate-x-0 transition-transform duration-300"
    >
        @include('partials.sidebar')
    </aside>

    {{-- Overlay mobile --}}
    <div 
        x-show="open"
        @click="open = false"
        class="fixed inset-0 bg-black opacity-40 md:hidden"
    ></div>

    <div class="flex-1 flex flex-col">

        {{-- Header --}}

            <!-- tombol mobile -->
            <button @click="open = true" class="md:hidden text-gray-700 text-xl">
                ☰
            </button>

            @include('partials.header')

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-white text-center p-3 text-sm text-gray-500">
            @include('partials.footer')
        </footer>

    </div>

</div>

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>