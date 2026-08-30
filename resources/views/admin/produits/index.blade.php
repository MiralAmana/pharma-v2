<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des Produits
            </h2>
        </div>
    </x-slot>

    <div class="py-10" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm font-semibold text-sm" style="color:#166534;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="font-extrabold text-gray-900 text-sm">{{ $produits->total() }} produit(s) au catalogue</span>
                </div>
                <a href="{{ route('admin.produits.create') }}" class="text-xs font-bold px-5 py-2.5 rounded-full text-white" style="background:#0284c7;">
                    + Nouveau produit
                </a>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($produits as $produit)
                    @php
                        $diasAvantPeremption = \Carbon\Carbon::now()->diffInDays($produit->date_peremption, false);
                    @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-4">

                        <div class="w-14 h-14 rounded-xl overflow-hidden shrink-0" style="background:#f7f8f7;">
                            @if($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h6M9 12h6M9 16h4"/></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm truncate">{{ $produit->nom }}</div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs text-gray-400">{{ $produit->categorie }}</span>
                                @if($produit->sur_ordonnance)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full" style="background:#fef2f2;color:#b91c1c;">
                                        Ordonnance
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="w-28 text-right font-extrabold text-gray-900 shrink-0">
                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                        </div>

                        <div class="w-28 shrink-0">
                            @if($produit->stock < 5)
                                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-full" style="background:#fef2f2;color:#b91c1c;">
                                    {{ $produit->stock }} en stock
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-full" style="background:#f0fdf4;color:#166534;">
                                    {{ $produit->stock }} en stock
                                </span>
                            @endif
                        </div>

                        <div class="w-32 shrink-0 text-xs font-semibold" style="color: {{ $diasAvantPeremption <= 90 ? '#b91c1c' : '#9ca3af' }};">
                            Exp. {{ \Carbon\Carbon::parse($produit->date_peremption)->format('d/m/Y') }}
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('admin.produits.edit', $produit->id) }}" class="w-9 h-9 rounded-full flex items-center justify-center border border-gray-200 hover:border-green-300" title="Modifier">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                            </a>
                            <form action="{{ route('admin.produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce médicament ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-full flex items-center justify-center border border-gray-200 hover:border-red-300" title="Supprimer">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-500">
                        Aucun produit en stock. Commencez par en ajouter un !
                    </div>
                @endforelse
            </div>

            <div>
                {{ $produits->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
