<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon Profil - PharmaPro</title>
    <script>
        (function () {
            var pref = localStorage.getItem('theme') || 'system';
            var isDark = pref === 'dark' || (pref === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) document.documentElement.classList.add('dark');
        })();
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">

    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="Logo Pharmacie" class="h-10 w-10 rounded-xl object-cover">
                <span class="text-xl font-extrabold"><span style="color:var(--navy);">Pharma</span><span style="color:var(--brand);">Pro</span></span>
            </a>

            <div class="flex items-center gap-3 sm:gap-6">
                <x-theme-toggle />
                <a href="{{ route('home') }}" class="hidden sm:inline text-sm font-semibold text-gray-600 hover:text-sky-700">
                    Retour à la boutique
                </a>
                <a href="{{ route('client.commandes.index') }}" class="hidden sm:inline text-sm font-semibold text-gray-600 hover:text-sky-700">
                    Mes commandes
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-bold px-4 py-2 rounded-full whitespace-nowrap" style="background:var(--danger-bg);color:var(--danger);">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <header class="text-center" style="background:linear-gradient(120deg,var(--hero-grad-1) 0%,var(--hero-grad-2) 55%,var(--hero-grad-3) 100%);">
        <div class="max-w-7xl mx-auto px-6 py-12 text-left">
            <h2 class="font-extrabold text-3xl" style="color:var(--navy);">
                Mon profil
            </h2>
            <p class="mt-2" style="color:var(--navy-soft);">Gérez vos informations personnelles et votre sécurité.</p>
        </div>
    </header>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-6 space-y-5">

            <div class="p-6 sm:p-8 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

</body>
</html>
