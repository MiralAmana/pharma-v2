<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon Profil - PharmaPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">

    <nav class="bg-white shadow p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
    <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-10 w-auto object-contain">
    <span class="text-2xl font-bold text-green-600">PharmaPro</span>
</a>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-green-600 font-semibold">
                    ← Retour à la boutique
                </a>
                
                <a href="{{ route('client.commandes.index') }}" class="ml-4 font-bold text-gray-700 hover:text-green-600">
                    📦 Mes Commandes
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 font-bold text-sm">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <header class="bg-green-600 py-10 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-3xl text-white leading-tight">
                👤 Mon Profil Client
            </h2>
            <p class="text-green-100 mt-2">Gérez vos informations personnelles et votre sécurité.</p>
        </div>
    </header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-green-500">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations du profil</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-blue-500">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Modifier le mot de passe</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-red-500">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-red-600 mb-4">Zone Danger</h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

</body>
</html>