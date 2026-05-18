<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Sewa Alat Bela Diri</title>

    @vite('resources/css/app.css')

    <style>
        [x-cloak] {
            display: none !important;
        }

        @media print {
            body {
                background: white !important;
            }

            aside,
            header,
            footer,
            .no-print {
                display: none !important;
            }

            main {
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-slate-100 overflow-hidden">

<div x-data="{ open: false }" class="h-screen flex overflow-hidden">

    {{-- SIDEBAR --}}
    <aside
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed md:static inset-y-0 left-0 z-50
               w-72 bg-blue-600 text-white
               transition-all duration-300 transform
               md:translate-x-0 flex flex-col shadow-2xl"
    >
        @include('partials.sidebar')
    </aside>

    {{-- OVERLAY MOBILE --}}
    <div
        x-show="open"
        x-cloak
        @click="open = false"
        class="fixed inset-0 bg-black/50 z-40 md:hidden"
    ></div>

    {{-- CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- HEADER --}}
        <header class="h-16 shrink-0 bg-white border-b shadow-sm z-30">
            @include('partials.header')
        </header>

        {{-- MAIN --}}
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="h-12 shrink-0 bg-white border-t">
            @include('partials.footer')
        </footer>

    </div>

</div>

<script defer src="https://unpkg.com/alpinejs"></script>

</body>
</html>