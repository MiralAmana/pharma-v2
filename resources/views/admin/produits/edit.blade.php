<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le médicament : <span class="text-blue-600">{{ $produit->nom }}</span>
        </h2>
    </x-slot>

    <div class="py-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-300 text-red-700 rounded p-4">
                            <p class="font-bold mb-2">Merci de corriger les erreurs suivantes :</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nom du produit *</label>
                            <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}" class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-blue-500" required>
                        </div>

                        <div class="mb-4">
    <label class="block text-gray-700 font-bold mb-2">Catégorie *</label>
    <select name="categorie" class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-blue-500" required>
        @foreach(\App\Models\Produit::CATEGORIES as $cat)
            <option value="{{ $cat }}" {{ old('categorie', $produit->categorie) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
</div>
<div class="mb-4 bg-red-50 p-4 rounded border border-red-200">
    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" name="sur_ordonnance" value="1"
               @checked(old('sur_ordonnance', $produit->sur_ordonnance))
               class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 h-5 w-5">
        <span class="ml-3 font-bold text-red-700">Ce médicament nécessite une ordonnance ⚠️</span>
    </label>
    <p class="text-xs text-red-500 mt-1 ml-8">Décochez cette case pour rendre le produit en vente libre.</p>
</div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Prix (FCFA) *</label>
                            <input type="number" name="prix" value="{{ old('prix', $produit->prix) }}" class="w-full border-2 border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Quantité en Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', $produit->stock) }}" class="w-full border-2 border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-red-600 font-bold mb-2">Date de Péremption *</label>
                            <input type="date" name="date_peremption" value="{{ old('date_peremption', $produit->date_peremption?->format('Y-m-d')) }}" class="w-full border-2 border-red-200 rounded px-3 py-2" required>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" class="w-full border-2 border-gray-300 rounded px-3 py-2" rows="3">{{ old('description', $produit->description) }}</textarea>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-gray-700 font-bold mb-2">Photo du produit</label>
                            @if($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-24 h-24 object-cover rounded mb-2 border">
                            @endif
                            <input type="file" name="image" accept="image/png,image/jpeg,image/webp" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Laisser vide pour conserver la photo actuelle.</p>
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