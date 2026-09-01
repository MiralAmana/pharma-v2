<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Commande Confirmée</title>
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
<body class="h-screen flex items-center justify-center" style="background:linear-gradient(120deg,var(--hero-grad-1) 0%,var(--hero-grad-2) 55%,var(--hero-grad-3) 100%); font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
    <div class="bg-white p-10 rounded-2xl shadow-lg text-center max-w-lg mx-4">
        <div class="w-16 h-16 rounded-full mx-auto mb-5 flex items-center justify-center" style="background:var(--sky-bg-1);">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m20 6-11 11-5-5"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Merci pour votre commande !</h1>
        <p class="text-gray-500 mb-7 text-sm leading-relaxed">
            Votre commande <strong class="text-gray-900">#{{ $commande->reference }}</strong> a bien été enregistrée.
            Elle est en attente de validation par le pharmacien.
        </p>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 rounded-full font-bold text-sm px-7 py-3 text-white" style="background:#0f2942;">
            Retour à l'accueil
        </a>
    </div>
</body>
</html>
