<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Commandes Clients
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3">Réf</th>
                            <th class="p-3">Client</th>
                            <th class="p-3">Contenu</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Preuve</th>
                            <th class="p-3">Statut</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes as $commande)
                        <tr class="border-b align-top">
                            <td class="p-3">{{ $commande->reference }}</td>
                            <td class="p-3">{{ $commande->user->name }}</td>
                            <td class="p-3">
                                <ul class="text-sm space-y-1">
                                    @foreach($commande->lignes as $ligne)
                                        <li>
                                            <span class="font-semibold">{{ $ligne->quantite }}×</span>
                                            {{ $ligne->produit->nom ?? 'Produit supprimé' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="p-3">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                            <td class="p-3">
    @if($commande->image_ordonnance)
        <a href="{{ route('ordonnances.show', $commande->id) }}" target="_blank" class="text-blue-600 underline text-sm flex items-center gap-1">
            📄 Voir l'ordonnance
        </a>
    @else
        <span class="text-gray-400 text-xs">Aucune</span>
    @endif
</td>
                            <td class="p-3">
                                @if($commande->statut == 'en_attente')
                                    <span class="text-yellow-600 font-bold">En attente</span>
                                @elseif($commande->statut == 'validée')
                                    <span class="text-green-600 font-bold">Validée</span>
                                @else
                                    <span class="text-red-600 font-bold">Annulée</span>
                                @endif
                            </td>
                            <td class="p-3 flex gap-2">
                                @if($commande->statut == 'en_attente')
                                    <form action="{{ route('admin.valider', $commande->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-green-600 font-bold">Valider</button>
                                    </form>
                                    <form action="{{ route('admin.annuler', $commande->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-600 font-bold">Annuler</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">Terminé</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>