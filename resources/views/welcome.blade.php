<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacie Aliou Baldé - Accueil</title>
    
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-white shadow p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <a href="/" class="flex items-center gap-2 group">
                <img src="{{ asset('logo.jpg') }}" alt="Logo Pharmacie" class="h-10 w-auto object-contain group-hover:scale-105 transition">
                <span class="text-2xl font-bold text-green-600">PharmaPro</span>
            </a>
            
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 font-semibold hover:text-green-600 flex items-center gap-1">
                        👤 <span class="hidden sm:inline">Mon Profil</span>
                    </a>

                    <a href="{{ route('client.commandes.index') }}" class="ml-4 font-bold text-gray-700 hover:text-green-600 flex items-center gap-1">
                        📦 <span class="hidden sm:inline">Mes Commandes</span>
                    </a>
                    
                    <a href="{{ route('cart.index') }}" class="ml-4 font-bold text-gray-700 hover:text-green-600 flex items-center gap-1 relative">
                        🛒 <span class="hidden sm:inline">Panier</span>
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">
                            {{ count((array) session('cart')) }}
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 font-semibold">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition font-bold shadow">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="bg-green-600 pt-10 pb-16 text-center text-white shadow-inner">
        <h1 class="text-4xl font-bold mb-4">Bienvenue à la Pharmacie Aliou Baldé</h1>
        <p class="mb-8 text-lg opacity-90">Trouvez vos médicaments et faites-vous livrer à domicile.</p>
        
        <form action="{{ route('home') }}" method="GET" class="max-w-xl mx-auto flex gap-2 px-4 mb-8">
            <input type="text" name="search" placeholder="Rechercher un médicament, un symptôme..." 
                   class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-4 focus:ring-green-300 shadow-lg"
                   value="{{ request('search') }}">
            <button type="submit" class="bg-gray-800 px-6 py-3 rounded-lg font-bold hover:bg-gray-900 shadow-lg transition transform hover:scale-105">
                🔍
            </button>
        </form>

        <div class="max-w-7xl mx-auto px-4">
            <p class="text-xs font-bold mb-3 text-green-100 uppercase tracking-widest">Parcourir par rayon</p>
            <div class="flex flex-wrap justify-center gap-3">
                
                <a href="/" class="px-4 py-2 rounded-full text-sm font-bold transition shadow-sm
                   {{ !request('categorie') ? 'bg-white text-green-700' : 'bg-green-700 text-white border border-green-400 hover:bg-green-800' }}">
                    Tout voir
                </a>

                @php
                    $cats = [
                        'Médicaments', 
                        'Santé & Bien-être', 
                        'Hygiène & Soins', 
                        'Matériel Médical', 
                        'Bébé & Maman', 
                        'Cosmétiques'
                    ];
                @endphp

                @foreach($cats as $cat)
                    <a href="{{ route('home', ['categorie' => $cat]) }}" 
                       class="px-4 py-2 rounded-full text-sm font-bold transition shadow-sm border border-transparent
                       {{ request('categorie') == $cat ? 'bg-white text-green-700' : 'bg-green-700 text-white border-green-400 hover:bg-green-800' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-12 flex-grow w-full">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Nos Produits Disponibles</h2>
            <span class="text-gray-500 text-sm">{{ count($produits) }} résultat(s)</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($produits as $produit)
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                
    
                    <div class="p-5 flex flex-col flex-grow">
                        
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-green-100 text-green-800 text-[10px] px-2 py-1 rounded-full uppercase font-bold tracking-wide border border-green-200">
                                {{ $produit->categorie }}
                            </span>

                            @if($produit->sur_ordonnance)
                                <span class="bg-red-50 text-red-600 text-[10px] px-2 py-1 rounded-full uppercase font-bold tracking-wide border border-red-200 flex items-center gap-1">
                                    ⚠️ Ordonnance
                                </span>
                            @endif
                        </div>

                        <h3 class="font-bold text-lg text-gray-800 leading-tight mb-2">{{ $produit->nom }}</h3>
                        
                        <p class="text-sm text-gray-500 mb-4 h-10 overflow-hidden line-clamp-2 leading-relaxed">
                            {{ $produit->description }}
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-50">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-green-600 font-extrabold text-xl">{{ number_format($produit->prix, 0, ',', ' ') }} <span class="text-sm">FCFA</span></span>
                            </div>
                            
                            @auth
                                <a href="{{ route('cart.add', $produit->id) }}" class="block w-full text-center bg-gray-800 text-white py-2.5 rounded-lg font-bold hover:bg-green-600 hover:shadow-lg transition transform active:scale-95">
                                    Ajouter au panier ➕
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center bg-gray-100 text-gray-500 py-2.5 rounded-lg font-semibold hover:bg-gray-200 transition text-sm">
                                    Se connecter pour acheter
                                </a>
                            @endauth
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-20 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="text-6xl mb-4">🔍</div>
                    <p class="text-gray-500 text-xl font-medium mb-4">Aucun produit ne correspond à votre recherche.</p>
                    <a href="/" class="text-white bg-green-600 px-6 py-2 rounded-lg font-bold hover:bg-green-700 transition shadow">
                        Voir tout le catalogue
                    </a>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Pharmacie Aliou Baldé. Tous droits réservés.</p>
            <p class="text-gray-400 text-sm mt-1">Votre santé, notre priorité.</p>
        </div>
    </footer>

</body>
</html>