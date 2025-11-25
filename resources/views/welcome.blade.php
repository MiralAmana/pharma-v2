<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacie Aliou Baldé</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-green-600 flex items-center gap-2">
                 PharmaPro
            </a>
            
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 font-semibold">Mon Compte</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="bg-green-600 py-16 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Bienvenue à la Pharmacie Aliou Baldé</h1>
        <p class="mb-8 text-lg">Trouvez vos médicaments et faites-vous livrer.</p>
        
        <form action="{{ route('home') }}" method="GET" class="max-w-xl mx-auto flex gap-2 px-4">
            <input type="text" name="search" placeholder="Rechercher un médicament (ex: Doliprane)..." 
                   class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none"
                   value="{{ request('search') }}">
            <button type="submit" class="bg-gray-800 px-6 py-3 rounded-lg font-bold hover:bg-gray-900">
                <p class=" text-lg">Rechercher</p>
            </button>
        </form>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Nos Produits Disponibles</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($produits as $produit)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden border border-gray-100">
    
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800">{{ $produit->nom }}</h3>
                        <p class="text-sm text-gray-500 mt-1 h-10 overflow-hidden">{{ $produit->description }}</p>
                        
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-green-600 font-bold text-xl">{{ $produit->prix }} FCFA</span>
                        </div>
                        
                        <button class="w-full mt-4 bg-gray-100 text-gray-400 py-2 rounded cursor-not-allowed">
                            Ajouter (Bientôt)
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-10">
                    <p class="text-gray-500 text-lg">Aucun produit trouvé pour cette recherche.</p>
                    <a href="/" class="text-green-600 font-bold mt-2 inline-block">Voir tous les produits</a>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>