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
                            <th class="p-3">Total</th>
                            <th class="p-3">Statut</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes as $commande)
                        <tr class="border-b">
                            <td class="p-3">{{ $commande->reference }}</td>
                            <td class="p-3">{{ $commande->user->name }}</td>
                            <td class="p-3">{{ $commande->total }} FCFA</td>
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
                                    <a href="{{ route('admin.valider', $commande->id) }}" class="text-green-600 font-bold">Valider</a>
                                    <a href="{{ route('admin.annuler', $commande->id) }}" class="text-red-600 font-bold">Annuler</a>
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