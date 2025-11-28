
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mes Commandes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow p-4 mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-green-600 font-bold text-xl">← Retour à la boutique</a>
            <h1 class="text-2xl font-bold text-gray-800">📦 Mes Commandes</h1>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4">
        
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4">Référence</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Montant Total</th>
                        <th class="p-4">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commandes as $commande)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-mono text-sm font-bold text-gray-700">
                            #{{ $commande->reference }}
                        </td>
                        <td class="p-4 text-gray-600">
                            {{ $commande->created_at->format('d/m/Y à H:i') }}
                        </td>
                        <td class="p-4 font-bold text-gray-800">
                            {{ number_format($commande->total, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="p-4">
                            @if($commande->statut == 'en_attente')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold flex items-center w-fit gap-2">
                                    ⏳ En attente
                                </span>
                            @elseif($commande->statut == 'validée')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold flex items-center w-fit gap-2">
                                    ✅ Validée
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold flex items-center w-fit gap-2">
                                    ❌ Annulée
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            Vous n'avez pas encore passé de commande.
                            <a href="/" class="text-green-600 font-bold hover:underline block mt-2">Commencer mes achats</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>