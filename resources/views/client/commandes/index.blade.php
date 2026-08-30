<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mes Commandes</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .badge-pill { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:12px; font-weight:700; }
    </style>
</head>
<body class="bg-gray-50" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">

    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.jpg') }}" alt="Logo Pharmacie" class="h-10 w-10 rounded-xl object-cover">
                <span class="text-xl font-extrabold text-gray-900">PharmaPro</span>
            </a>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-sky-700 flex items-center gap-1.5">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Retour à la boutique
            </a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-10">
        <span class="text-xs font-bold uppercase tracking-widest" style="color:#0284c7;">Mon espace</span>
        <h1 class="text-2xl font-extrabold text-gray-900 mt-1 mb-1">Mes commandes</h1>
        <p class="text-sm text-gray-500 mb-8">Suivez l'état de vos commandes et retrouvez votre historique d'achats.</p>

        <div class="flex flex-col gap-3">
            @forelse($commandes as $commande)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-6 {{ $commande->statut == 'annulée' ? 'opacity-70' : '' }}">
                    <div class="w-28 shrink-0">
                        <div class="font-mono font-bold text-sm text-gray-900">{{ $commande->reference }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $commande->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div class="flex-1 text-sm text-gray-500">
                        Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}
                    </div>
                    <div class="w-40 shrink-0">
                        @if($commande->statut == 'en_attente')
                            <span class="badge-pill" style="background:#fffbeb;color:#b45309;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#b45309" stroke-width="2.2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                                En attente
                            </span>
                        @elseif($commande->statut == 'validée')
                            <span class="badge-pill" style="background:#f0fdf4;color:#166534;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="m20 6-11 11-5-5"/></svg>
                                Validée
                            </span>
                        @else
                            <span class="badge-pill" style="background:#fef2f2;color:#b91c1c;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="2.4"><circle cx="12" cy="12" r="9"/><path d="m9.5 9.5 5 5m0-5-5 5"/></svg>
                                Annulée
                            </span>
                        @endif
                    </div>
                    <div class="w-28 text-right font-extrabold text-gray-900 shrink-0 {{ $commande->statut == 'annulée' ? 'line-through' : '' }}">
                        {{ number_format($commande->total, 0, ',', ' ') }} FCFA
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-500">
                    Vous n'avez pas encore passé de commande.
                    <a href="{{ route('home') }}" class="text-sky-700 font-bold hover:underline block mt-2">Commencer mes achats</a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $commandes->links() }}
        </div>
    </div>

</body>
</html>
