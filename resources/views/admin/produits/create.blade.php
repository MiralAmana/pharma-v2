<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un nouveau médicament
        </h2>
    </x-slot>

    <div class="py-10" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data" class="p-7">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-6 rounded-xl p-4" style="background:#fef2f2;border:1px solid #fecaca;">
                            <p class="font-bold text-sm mb-2" style="color:#b91c1c;">Merci de corriger les erreurs suivantes :</p>
                            <ul class="list-disc list-inside text-xs" style="color:#b91c1c;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-2">

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Nom du produit *</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Ex: Doliprane 1000mg" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Catégorie *</label>
                            <select name="categorie" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" required>
                                @foreach(\App\Models\Produit::CATEGORIES as $cat)
                                    <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Prix (FCFA) *</label>
                            <input type="number" name="prix" value="{{ old('prix') }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Ex: 1500" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Quantité en stock *</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Ex: 50" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Date de péremption *</label>
                            <input type="date" name="date_peremption" value="{{ old('date_peremption') }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" required>
                        </div>

                        <div class="flex items-end">
                            <label class="flex items-center gap-3 rounded-xl px-4 py-3 w-full cursor-pointer" style="background:#fef2f2;border:1px solid #fecaca;">
                                <input type="checkbox" name="sur_ordonnance" value="1" @checked(old('sur_ordonnance')) class="rounded border-gray-300 text-red-600 focus:ring-red-300 h-4 w-4">
                                <span class="text-xs font-bold" style="color:#b91c1c;">Nécessite une ordonnance</span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Description</label>
                            <textarea name="description" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" rows="3" placeholder="Description courte...">{{ old('description') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Photo du produit</label>
                            <input type="file" name="image" accept="image/png,image/jpeg,image/webp" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                        </div>

                    </div>

                    <div class="mt-6 pt-5 border-t border-gray-100 flex justify-end items-center gap-4">
                        <a href="{{ route('admin.produits.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700">
                            Annuler
                        </a>
                        <button type="submit" class="text-sm font-bold px-6 py-3 rounded-full text-white" style="background:#0284c7;">
                            Enregistrer le produit
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
