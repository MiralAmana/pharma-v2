<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenue, Docteur 👋
        </h2>
    </x-slot>

    <div class="py-10" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm" style="border-left:3px solid #d97706;">
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="text-xs font-bold text-gray-500">Commandes en attente</span>
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background:#fffbeb;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b45309" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 mb-1.5">{{ $commandesEnAttente }}</div>
                    <a href="{{ route('admin.commandes') }}" class="text-xs font-bold text-yellow-700">Traiter maintenant →</a>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm" style="border-left:3px solid #6d28d9;">
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="text-xs font-bold text-gray-500">Produits au catalogue</span>
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background:#f5f3ff;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6d28d9" stroke-width="2"><path d="M20 7 12 3 4 7v10l8 4 8-4Z"/><path d="M4 7l8 4 8-4M12 11v10"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 mb-1.5">{{ $totalProduits }}</div>
                    <span class="text-xs font-semibold text-gray-400">Au catalogue actif</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm" style="border-left:3px solid #dc2626;">
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="text-xs font-bold text-gray-500">Alertes stock</span>
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background:#fef2f2;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="2"><path d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 mb-1.5">{{ $alerteStock }}</div>
                    <span class="text-xs font-semibold text-gray-400">Produits &lt; 5 unités</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm" style="border-left:3px solid #16a34a;">
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="text-xs font-bold text-gray-500">Chiffre d'affaires</span>
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background:#f0fdf4;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2"><path d="m23 6-9.5 9.5-5-5L1 18"/><path d="M17 6h6v6"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-green-700 mb-1.5">{{ number_format($chiffreAffaires, 0, ',', ' ') }} <span class="text-sm">FCFA</span></div>
                    <span class="text-xs font-semibold text-gray-400">Commandes validées</span>
                </div>

            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <span class="font-bold text-gray-900 text-sm shrink-0">Actions rapides</span>
                <a href="{{ route('admin.produits.create') }}" class="flex-1 text-center rounded-full font-bold text-sm py-2.5" style="background:#eff6ff;color:#1d4ed8;">
                    + Ajouter un produit
                </a>
                <a href="{{ route('admin.commandes') }}" class="flex-1 text-center rounded-full font-bold text-sm py-2.5" style="background:#fffbeb;color:#b45309;">
                    Voir les commandes en attente
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="2"><path d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
                        <h3 class="font-extrabold text-gray-900">Risques de péremption (3 mois)</h3>
                    </div>

                    @if($alertePeremption->count() > 0)
                        <div class="flex flex-col">
                            @foreach($alertePeremption as $lot)
                                <div class="flex items-center gap-3 py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $lot->produit->nom ?? 'Produit supprimé' }}</div>
                                        <div class="text-xs text-gray-400">{{ $lot->quantite }} unité(s) sur ce lot</div>
                                    </div>
                                    <span class="text-xs font-bold text-red-600 w-24 shrink-0">{{ $lot->date_peremption->format('d/m/Y') }}</span>
                                    <span class="text-xs text-gray-400 w-16 shrink-0">dans {{ (int) Carbon\Carbon::now()->diffInDays($lot->date_peremption) }} j</span>
                                    @if($lot->produit)
                                        <a href="{{ route('admin.produits.edit', $lot->produit_id) }}" class="text-xs font-bold text-sky-700 shrink-0">Gérer</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-green-700 font-semibold text-sm p-4 rounded-xl" style="background:#f0fdf4;">
                            ✅ Aucun lot ne périme bientôt.
                        </p>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2"><path d="m23 6-9.5 9.5-5-5L1 18"/><path d="M17 6h6v6"/></svg>
                        <h3 class="font-extrabold text-gray-900">Produits phares — Top 5 ventes</h3>
                    </div>

                    @if($topProduits->count() > 0)
                        @php $maxVendus = max(1, $topProduits->max('total_vendus')); @endphp
                        <div class="flex flex-col gap-3.5">
                            @foreach($topProduits as $index => $item)
                                @if($item->produit)
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-extrabold shrink-0 {{ $index == 0 ? 'text-white' : 'text-gray-700' }}" style="background:{{ $index == 0 ? '#0369a1' : '#e5e7eb' }};">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="flex-1 text-sm font-semibold text-gray-900 truncate">{{ $item->produit->nom }}</span>
                                        <div class="w-20 h-1.5 rounded-full bg-gray-100 overflow-hidden shrink-0">
                                            <div class="h-full bg-sky-600" style="width: {{ round($item->total_vendus / $maxVendus * 100) }}%;"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-500 w-16 text-right shrink-0">{{ $item->total_vendus }} vendus</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic text-sm">Pas assez de données de vente.</p>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
