<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PharmaPro') }}</title>
        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
        <script>
            (function () {
                var pref = localStorage.getItem('theme') || 'system';
                var isDark = pref === 'dark' || (pref === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                if (isDark) document.documentElement.classList.add('dark');
            })();
        </script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: linear-gradient(120deg,var(--hero-grad-1) 0%,var(--hero-grad-2) 55%,var(--hero-grad-3) 100%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <x-theme-toggle class="glass-pill fixed top-5 right-5 z-10" />
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6 text-center">
    <a href="/" class="flex flex-col items-center gap-2">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-20 w-auto object-contain">

        <span class="font-bold text-3xl"><span style="color:var(--navy);">Pharma</span><span style="color:var(--brand);">Pro</span></span>
    </a>
    <p class="mt-2" style="color:var(--navy-soft);">Votre pharmacie en ligne de confiance</p>
</div>

            <div class="glass-card w-full sm:max-w-md mt-6 px-6 py-8 shadow-lg overflow-hidden sm:rounded-2xl" style="border-top:4px solid var(--brand);">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>