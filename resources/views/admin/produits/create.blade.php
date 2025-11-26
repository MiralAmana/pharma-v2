<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un nouveau médicament
        </h2>
    </x-slot>

    <div class="py-12 pb-20"> <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.produits.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nom du médicament *</label>
                            <input type="text" name="nom" class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-green-500 focus:ring-green-500" placeholder="Ex: Doliprane 1000mg" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Prix (FCFA) *</label>
                            <input type="number" name="prix" class="w-full border-2 border-gray-300 rounded px-3 py-2" placeholder="Ex: 1500" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Quantité en Stock *</label>
                            <input type="number" name="stock" class="w-full border-2 border-gray-300 rounded px-3 py-2" placeholder="Ex: 50" required>
                        </div>

                        <div>
                            <label class="block text-red-600 font-bold mb-2">Date de Péremption *</label>
                            <input type="date" name="date_peremption" class="w-full border-2 border-red-200 rounded px-3 py-2" required>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" class="w-full border-2 border-gray-300 rounded px-3 py-2" rows="3" placeholder="Description courte..."></textarea>
                        </div>

                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end items-center gap-4 bg-gray-50 p-4 -mx-6 -mb-6">
                        
                        <a href="{{ route('admin.produits.index') }}" class="text-gray-600 font-bold hover:underline">
                            Annuler
                        </a>

                        <button type="submit" 
                                style="background-color: #16a34a; color: white; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 16px;">
                            ✅ ENREGISTRER LE PRODUIT
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>