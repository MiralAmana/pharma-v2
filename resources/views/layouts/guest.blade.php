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
            /* Un petit motif de fond subtil pour faire "médical" */
            body {
                background-color: #f0fdf4; /* Vert très clair */
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2316a34a' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6 text-center">
    <a href="/" class="flex flex-col items-center gap-2">
        <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-20 w-auto object-contain">
        
        <span class="font-bold text-3xl text-green-700">PharmaPro</span>
    </a>
    <p class="text-green-600 mt-2">Votre pharmacie en ligne de confiance</p>
</div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-xl border-t-4 border-green-500">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>