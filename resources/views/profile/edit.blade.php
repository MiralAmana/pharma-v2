<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon Profil - PharmaPro</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.jpg') }}" alt="Logo Pharmacie" class="h-10 w-10 rounded-xl object-cover">
                <span class="text-xl font-extrabold text-gray-900">PharmaPro</span>
            </a>

            <div class="flex items-center gap-3 sm:gap-6">
                <a href="{{ route('home') }}" class="hidden sm:inline text-sm font-semibold text-gray-600 hover:text-sky-700">
                    Retour à la boutique
                </a>
                <a href="{{ route('client.commandes.index') }}" class="hidden sm:inline text-sm font-semibold text-gray-600 hover:text-sky-700">
                    Mes commandes
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-bold px-4 py-2 rounded-full whitespace-nowrap" style="background:#fef2f2;color:#b91c1c;">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <header class="text-center" style="background:linear-gradient(120deg,#e6f7ff 0%,#d6f0fb 55%,#c7e9f8 100%);">
        <div class="max-w-7xl mx-auto px-6 py-12 text-left">
            <h2 class="font-extrabold text-3xl" style="color:#0f2942;">
                Mon profil
            </h2>
            <p class="mt-2" style="color:#3a5670;">Gérez vos informations personnelles et votre sécurité.</p>
        </div>
    </header>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-6 space-y-5">

            <div class="p-6 sm:p-8 bg-white rounded-2xl border border-gray-100 shadow-sm" style="border-left:4px solid #0284c7;">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white rounded-2xl border border-gray-100 shadow-sm" style="border-left:4px solid #0284c7;">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white rounded-2xl border border-gray-100 shadow-sm" style="border-left:4px solid #b91c1c;">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

</body>
</html>
