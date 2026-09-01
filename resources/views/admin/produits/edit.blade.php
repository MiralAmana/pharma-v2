<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le médicament : <span style="color:var(--brand-hover);">{{ $produit->nom }}</span>
        </h2>
    </x-slot>

    <div class="py-10" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" class="p-7">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="mb-6 rounded-xl p-4" style="background:var(--danger-bg);border:1px solid var(--danger-border);">
                            <p class="font-bold text-sm mb-2" style="color:var(--danger);">Merci de corriger les erreurs suivantes :</p>
                            <ul class="list-disc list-inside text-xs" style="color:var(--danger);">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-2">

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Nom du produit *</label>
                            <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Catégorie *</label>
                            <select name="categorie" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" required>
                                @foreach(\App\Models\Produit::CATEGORIES as $cat)
                                    <option value="{{ $cat }}" {{ old('categorie', $produit->categorie) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Prix (FCFA) *</label>
                            <input type="number" name="prix" value="{{ old('prix', $produit->prix) }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" required>
                        </div>

                        <div class="md:col-span-2">
                            <div class="rounded-xl px-4 py-3 flex items-center justify-between" style="background:var(--sky-bg-2);">
                                <span class="text-xs font-bold text-gray-500">Stock actuel (calculé à partir des lots ci-dessous)</span>
                                <span class="text-lg font-extrabold" style="color:var(--brand-hover);">{{ $produit->stock }} unité(s)</span>
                            </div>
                        </div>

                        <div class="flex items-end">
                            <label class="flex items-center gap-3 rounded-xl px-4 py-3 w-full cursor-pointer" style="background:var(--danger-bg);border:1px solid var(--danger-border);">
                                <input type="checkbox" name="sur_ordonnance" value="1"
                                       @checked(old('sur_ordonnance', $produit->sur_ordonnance))
                                       class="rounded border-gray-300 text-red-600 focus:ring-red-300 h-4 w-4">
                                <span class="text-xs font-bold" style="color:var(--danger);">Nécessite une ordonnance</span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Description</label>
                            <textarea name="description" class="w-full rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500" rows="3">{{ old('description', $produit->description) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Photo du produit</label>
                            @if($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-20 h-20 object-cover rounded-xl mb-3 border border-gray-100">
                            @endif
                            <input type="file" name="image" accept="image/png,image/jpeg,image/webp" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                            <p class="text-xs text-gray-400 mt-1.5">Laisser vide pour conserver la photo actuelle.</p>
                        </div>

                    </div>

                    <div class="mt-6 pt-5 border-t border-gray-100 flex justify-end items-center gap-4">
                        <a href="{{ route('admin.produits.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700">
                            Annuler
                        </a>
                        <button type="submit" class="text-sm font-bold px-6 py-3 rounded-full text-white" style="background:var(--brand);">
                            Enregistrer les modifications
                        </button>
                    </div>

                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-7 mt-5">
                <h3 class="font-extrabold text-gray-900 mb-1">Lots en stock</h3>
                <p class="text-xs text-gray-400 mb-4">Chaque réception de marchandise est un lot avec sa propre date de péremption. À la vente, le lot qui périme le plus tôt est déduit en premier (FEFO).</p>

                @if($produit->lots->isEmpty())
                    <p class="text-sm text-gray-500 italic mb-5">Aucun lot pour ce produit — stock à 0.</p>
                @else
                    <div class="flex flex-col mb-5">
                        @foreach($produit->lots as $lot)
                            @php $diasAvant = \Carbon\Carbon::now()->diffInDays($lot->date_peremption, false); @endphp
                            <div class="flex items-center gap-3 py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                <span class="font-bold text-gray-900 text-sm w-24">{{ $lot->quantite }} unité(s)</span>
                                <span class="text-sm font-semibold w-28" style="color: {{ $diasAvant <= 90 ? 'var(--danger)' : 'var(--gray-text-1)' }};">
                                    {{ $lot->date_peremption->format('d/m/Y') }}
                                </span>
                                <span class="text-xs text-gray-400 flex-1">{{ $lot->numero_lot ? 'Lot n°'.$lot->numero_lot : '—' }}</span>
                                <form action="{{ route('admin.produits.lots.destroy', [$produit->id, $lot->id]) }}" method="POST" onsubmit="return confirm('Supprimer ce lot ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800">Supprimer</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.produits.lots.store', $produit->id) }}" method="POST" class="flex flex-wrap items-end gap-3 pt-4 border-t border-gray-100">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">Quantité reçue *</label>
                        <input type="number" name="quantite" min="1" required class="rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500 w-32">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">Date de péremption *</label>
                        <input type="date" name="date_peremption" required class="rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">N° de lot</label>
                        <input type="text" name="numero_lot" class="rounded-xl border-gray-200 text-sm focus:border-sky-500 focus:ring-sky-500 w-32" placeholder="Optionnel">
                    </div>
                    <button type="submit" class="text-sm font-bold px-5 py-2.5 rounded-full text-white" style="background:var(--success);">
                        + Réceptionner ce lot
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
