<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Commandes Clients
        </h2>
    </x-slot>

    <div class="py-10" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row sm:items-center gap-4">
                <form action="{{ route('admin.commandes') }}" method="GET" class="flex-1 flex items-center gap-2 rounded-full bg-gray-50 border border-gray-100 px-4 py-2.5">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--gray-icon)" stroke-width="2" class="shrink-0"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="recherche" value="{{ request('recherche') }}" placeholder="Rechercher par référence ou client…" class="flex-1 bg-transparent border-0 focus:ring-0 text-sm p-0">
                    @if(request('statut'))
                        <input type="hidden" name="statut" value="{{ request('statut') }}">
                    @endif
                </form>

                <div class="flex items-center gap-2 flex-wrap">
                    @php
                        $statuts = [
                            null => 'Toutes',
                            'en_attente' => 'En attente',
                            'validée' => 'Validées',
                            'annulée' => 'Annulées',
                        ];
                    @endphp
                    @foreach($statuts as $value => $label)
                        <a href="{{ route('admin.commandes', array_filter(['statut' => $value, 'recherche' => request('recherche')])) }}"
                           class="text-xs font-bold px-4 py-2 rounded-full"
                           style="{{ request('statut') == $value ? 'background:var(--brand);color:#fff;' : 'background:var(--border-2);color:var(--gray-text-3);' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col gap-3.5">
                @forelse($commandes as $commande)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col md:flex-row md:items-center gap-4 {{ $commande->statut == 'annulée' ? 'opacity-70' : '' }}">

                        <div class="w-32 shrink-0">
                            <div class="font-mono font-bold text-sm text-gray-900">{{ $commande->reference }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $commande->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="w-40 shrink-0">
                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $commande->user->name }}</div>
                            <div class="text-xs text-gray-400 truncate">{{ $commande->user->email }}</div>
                        </div>

                        <div class="flex-1 min-w-0 text-xs text-gray-500">
                            @foreach($commande->lignes as $ligne)
                                <span class="inline-block mr-2">
                                    <span class="font-bold text-gray-700">{{ $ligne->quantite }}×</span>
                                    {{ $ligne->produit->nom ?? 'Produit supprimé' }}{{ !$loop->last ? ',' : '' }}
                                </span>
                            @endforeach
                        </div>

                        <div class="w-28 text-right font-extrabold text-gray-900 shrink-0">
                            {{ number_format($commande->total, 0, ',', ' ') }} FCFA
                        </div>

                        <div class="w-28 shrink-0">
                            @if($commande->image_ordonnance)
                                <a href="{{ route('ordonnances.show', $commande->id) }}" target="_blank" class="text-xs font-bold text-blue-700 flex items-center gap-1">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--blue-text)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/></svg>
                                    Ordonnance
                                </a>
                            @else
                                <span class="text-xs text-gray-300">—</span>
                            @endif
                        </div>

                        <div class="w-32 shrink-0">
                            @if($commande->statut == 'en_attente')
                                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-full" style="background:var(--warning-bg);color:var(--warning-text);">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--warning-text)" stroke-width="2.2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                                    En attente
                                </span>
                            @elseif($commande->statut == 'validée')
                                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-full" style="background:var(--success-bg);color:var(--success-text);">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--success-text)" stroke-width="2.6"><path d="m20 6-11 11-5-5"/></svg>
                                    Validée
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-full" style="background:var(--danger-bg);color:var(--danger);">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2.4"><circle cx="12" cy="12" r="9"/><path d="m9.5 9.5 5 5m0-5-5 5"/></svg>
                                    Annulée
                                </span>
                            @endif
                            @if($commande->traitePar)
                                <div class="text-[11px] text-gray-400 mt-1">
                                    par {{ $commande->traitePar->name }}
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            @if($commande->statut == 'en_attente')
                                <form action="{{ route('admin.valider', $commande->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold px-4 py-2 rounded-full text-white" style="background:var(--success);">Valider</button>
                                </form>
                                <form action="{{ route('admin.annuler', $commande->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold px-4 py-2 rounded-full" style="background:var(--danger-bg);color:var(--danger);">Annuler</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-300 px-2">Terminé</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-500">
                        Aucune commande ne correspond à ces critères.
                    </div>
                @endforelse
            </div>

            <div>
                {{ $commandes->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
