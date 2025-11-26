<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Tableau de Bord - Gérant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="text-2xl font-bold text-gray-800">👨‍⚕️ Espace Gérant</span>
                <div class="h-6 w-px bg-gray-300"></div>
                <a href="{{ route('dashboard') }}" class="font-bold text-green-600">Tableau de bord</a>
                <a href="{{ route('admin.commandes') }}" class="text-gray-600 hover:text-green-600">Commandes</a>
                <a href="{{ route('admin.produits.index') }}" class="text-gray-600 hover:text-green-600">Produits</a>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="/" class="text-blue-600 text-sm">Voir le site client</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-sm">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Bienvenue, Docteur.</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
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
    </div>

</body>
</html>