<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👨‍⚕️ Tableau de Bord — Bienvenue, Docteur.
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                    <div class="text-gray-500 font-bold mb-2">Commandes en attente</div>
                    <div class="text-4xl font-bold text-yellow-600">{{ $commandesEnAttente }}</div>
                    <a href="{{ route('admin.commandes') }}" class="text-sm text-yellow-600 underline mt-2 block">Traiter maintenant →</a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-gray-500 font-bold mb-2">Total Produits</div>
                    <div class="text-4xl font-bold text-blue-600">{{ $totalProduits }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <div class="text-gray-500 font-bold mb-2">Alertes Stock</div>
                    <div class="text-4xl font-bold text-red-600">{{ $alerteStock }}</div>
                    <div class="text-xs text-red-400">Produits < 5 unités</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-gray-500 font-bold mb-2">Chiffre d'Affaires</div>
                    <div class="text-3xl font-bold text-green-600">{{ number_format($chiffreAffaires, 0, ',', ' ') }} FCFA</div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-xl mb-4">Gestion Rapide</h3>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.produits.create') }}" class="flex-1 bg-blue-100 text-blue-700 py-3 rounded text-center font-bold hover:bg-blue-200">
                            + Ajouter un produit
                        </a>
                        <a href="{{ route('admin.commandes') }}" class="flex-1 bg-yellow-100 text-yellow-700 py-3 rounded text-center font-bold hover:bg-yellow-200">
                            Voir les commandes
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="bg-white p-6 rounded-lg shadow border-t-4 border-red-500">
                    <h3 class="font-bold text-xl text-gray-800 mb-4 flex items-center gap-2">
                        ⚠️ Risques de Péremption (3 mois)
                    </h3>

                    @if($alertePeremption->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-red-50 text-red-700">
                                    <tr>
                                        <th class="p-2">Produit</th>
                                        <th class="p-2">Date Limite</th>
                                        <th class="p-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alertePeremption as $prod)
                                        <tr class="border-b">
                                            <td class="p-2 font-bold">{{ $prod->nom }}</td>
                                            <td class="p-2 text-red-600 font-bold">
                                                {{ \Carbon\Carbon::parse($prod->date_peremption)->format('d/m/Y') }}
                                                <span class="text-xs text-gray-500">
                                                    (dans {{ \Carbon\Carbon::now()->diffInDays($prod->date_peremption) }} j)
                                                </span>
                                            </td>
                                            <td class="p-2">
                                                <a href="{{ route('admin.produits.edit', $prod->id) }}" class="text-blue-600 hover:underline">Gérer</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-green-600 font-bold bg-green-50 p-4 rounded">
                            ✅ Aucun produit ne périme bientôt.
                        </p>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-t-4 border-blue-500">
                    <h3 class="font-bold text-xl text-gray-800 mb-4 flex items-center gap-2">
                        🏆 Produits Phares (Top 5 Ventes)
                    </h3>

                    @if($topProduits->count() > 0)
                        <ul>
                            @foreach($topProduits as $index => $item)
                                @if($item->produit)
                                <li class="flex justify-between items-center py-3 border-b last:border-0">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-gray-200 text-gray-700 font-bold w-6 h-6 flex items-center justify-center rounded-full text-xs">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="font-semibold text-gray-700">{{ $item->produit->nom }}</span>
                                    </div>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $item->total_vendus }} vendus
                                    </span>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 italic">Pas assez de données de vente.</p>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
