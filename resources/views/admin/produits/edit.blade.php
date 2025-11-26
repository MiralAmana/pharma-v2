<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le médicament : <span class="text-blue-600">{{ $produit->nom }}</span>
        </h2>
    </x-slot>

    <div class="py-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT') 

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nom du médicament *</label>
                            <input type="text" name="nom" value="{{ $produit->nom }}" class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Prix (FCFA) *</label>
                            <input type="number" name="prix" value="{{ $produit->prix }}" class="w-full border-2 border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Quantité en Stock *</label>
                            <input type="number" name="stock" value="{{ $produit->stock }}" class="w-full border-2 border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-red-600 font-bold mb-2">Date de Péremption *</label>
                            <input type="date" name="date_peremption" value="{{ $produit->date_peremption }}" class="w-full border-2 border-red-200 rounded px-3 py-2" required>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" class="w-full border-2 border-gray-300 rounded px-3 py-2" rows="3">{{ $produit->description }}</textarea>
                        </div>

                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end items-center gap-4 bg-gray-50 p-4 -mx-6 -mb-6">
                        
                        <a href="{{ route('admin.produits.index') }}" class="text-gray-600 font-bold hover:underline">
                            Annuler
                        </a>

                        <button type="submit" 
                                style="background-color: #2563eb; color: white; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 16px;">
                            💾 ENREGISTRER LES MODIFICATIONS
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>