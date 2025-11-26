<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des Stocks
            </h2>
            <a href="{{ route('admin.produits.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700">
                + Nouveau Produit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4 font-bold border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th class="p-3 font-semibold text-gray-600">Nom</th>
                            <th class="p-3 font-semibold text-gray-600">Prix</th>
                            <th class="p-3 font-semibold text-gray-600">Stock</th>
                            <th class="p-3 font-semibold text-gray-600">Péremption</th>
                            <th class="p-3 font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $produit)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3 font-bold text-gray-800">{{ $produit->nom }}</td>
                            <td class="p-3">{{ $produit->prix }} FCFA</td>
                            <td class="p-3">
                                @if($produit->stock < 5)
                                    <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded">{{ $produit->stock }} (Faible)</span>
                                @else
                                    <span class="text-green-600 font-bold bg-green-100 px-2 py-1 rounded">{{ $produit->stock }}</span>
                                @endif
                            </td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($produit->date_peremption)->format('d/m/Y') }}</td>
                            
                            <td class="p-3 flex items-center gap-4">
                                
                                <a href="{{ route('admin.produits.edit', $produit->id) }}" class="text-blue-500 hover:text-blue-700 text-xl transition transform hover:scale-110" title="Modifier">
                                    ✏️
                                </a>

                                <form action="{{ route('admin.produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce médicament ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xl transition transform hover:scale-110" title="Supprimer">
                                        🗑️
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($produits->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        Aucun produit en stock. Commencez par en ajouter un !
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>