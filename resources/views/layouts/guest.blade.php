<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PharmaPro') }}</title>
        <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: linear-gradient(120deg,#e6f7ff 0%,#d6f0fb 55%,#c7e9f8 100%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6 text-center">
    <a href="/" class="flex flex-col items-center gap-2">
        <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-20 w-auto object-contain">

        <span class="font-bold text-3xl" style="color:#0f2942;">PharmaPro</span>
    </a>
    <p class="mt-2" style="color:#3a5670;">Votre pharmacie en ligne de confiance</p>
</div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-2xl" style="border-top:4px solid #0284c7;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>