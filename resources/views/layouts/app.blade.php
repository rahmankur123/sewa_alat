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
        overflow: visible !important;
    }

    aside, header, footer {
        display: none !important;
    }

    main {
        padding: 0 !important;
    }

    .no-print {
        display: none !important;
    }

    .print-area {
        width: 100%;
        margin: 0;
        padding: 0;
    }

}
</style>
</head>

<body class="bg-gray-100 overflow-hidden">

<div class="flex h-screen overflow-hidden">
    
    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col h-full">
        
        {{-- Header --}}
        @include('partials.header')

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('partials.footer')

    </div>

</div>

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>