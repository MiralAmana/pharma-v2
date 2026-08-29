<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mon Panier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <div class="bg-white shadow p-4 mb-6">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Mon Panier 🛒</h1>
            <a href="/" class="text-green-600 hover:underline">← Retour aux achats</a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3">Produit</th>
                        <th class="p-3">Prix</th>
                        <th class="p-3">Quantité</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalGlobal = 0 @endphp

                    @forelse($cart as $id => $details)
                        @php
                            $totalLigne = $details['price'] * $details['quantity'];
                            $totalGlobal += $totalLigne;
                        @endphp
                        <tr class="border-b">
                            <td class="p-3 font-bold">{{ $details['name'] }}</td>
                            <td class="p-3">{{ number_format($details['price'], 0, ',', ' ') }} FCFA</td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('cart.decrease', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-7 h-7 rounded bg-gray-200 hover:bg-gray-300 font-bold" title="Diminuer">−</button>
                                    </form>
                                    <span class="w-6 text-center">{{ $details['quantity'] }}</span>
                                    <form action="{{ route('cart.add', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-7 h-7 rounded bg-gray-200 hover:bg-gray-300 font-bold" title="Augmenter">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="p-3 text-green-600 font-bold">{{ number_format($totalLigne, 0, ',', ' ') }} FCFA</td>
                            <td class="p-3">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">
                                        Retirer ❌
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                Votre panier est vide pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(!empty($cart))
    <div class="mt-8 bg-white p-6 rounded shadow border-t-4 border-green-500">

        <div class="flex justify-between items-end">
            <div class="text-2xl font-bold">Total : {{ number_format($totalGlobal, 0, ',', ' ') }} FCFA</div>

            <form action="{{ route('checkout.valider') }}" method="POST" enctype="multipart/form-data" class="text-right">
                @csrf

                @if($needsPrescription)
                    <div class="mb-4 text-left bg-red-50 p-4 rounded border border-red-200">
                        <label class="block text-red-700 font-bold mb-2">
                            ⚠️ Ordonnance Requise
                        </label>
                        <p class="text-sm text-gray-600 mb-2">
                            Votre panier contient des médicaments sur ordonnance. Veuillez télécharger une photo de votre ordonnance médicale pour continuer.
                        </p>
                        <input type="file" name="ordonnance" accept="image/*,.pdf" required
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                @endif

                <button type="submit" class="bg-green-600 text-white py-3 px-8 rounded-lg font-bold hover:bg-green-700 shadow transition transform hover:scale-105">
                    Valider
                </button>
            </form>
        </div>
    </div>
@endif

    </div>
</body>
</html>
