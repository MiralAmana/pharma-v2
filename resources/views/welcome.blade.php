<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacie Aliou Baldé - Accueil</title>
    <script>
        (function () {
            var pref = localStorage.getItem('theme') || 'system';
            var isDark = pref === 'dark' || (pref === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) document.documentElement.classList.add('dark');
        })();
    </script>

    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .btn-pill { display:inline-flex; align-items:center; justify-content:center; gap:8px; border-radius:999px; font-weight:700; font-size:14px; cursor:pointer; border:none; }
        .btn-navy { background:#0f2942; color:#fff; padding:13px 26px; }
        .btn-navy:hover { background:var(--btn-navy-hover); }
        .btn-outline { background:var(--surface); color:var(--brand-hover); border:1.5px solid var(--sky-border); padding:11.5px 26px; }
        .btn-outline:hover { background:var(--sky-bg-2); }
        .btn-blue { background:var(--brand); color:#fff; }
        .btn-blue:hover { background:var(--brand-hover); }
        .iconbtn { width:38px; height:38px; border-radius:999px; border:1.5px solid var(--border-1); display:flex; align-items:center; justify-content:center; }
        .badge-pill { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
        .cat-card { border-radius:20px; padding:22px; display:flex; flex-direction:column; gap:10px; transition:transform .15s; }
        .cat-card:hover { transform:translateY(-3px); }

        /* Fondu doux à l'arrivée sur la page (catalogue, changement de page) plutôt qu'un
           affichage brut d'un coup — surtout sensible en avançant dans la pagination. */
        @keyframes fadeInUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .product-card { animation: fadeInUp .4s ease both; }
        .product-card:nth-child(4n+1) { animation-delay: 0ms; }
        .product-card:nth-child(4n+2) { animation-delay: 40ms; }
        .product-card:nth-child(4n+3) { animation-delay: 80ms; }
        .product-card:nth-child(4n+4) { animation-delay: 120ms; }
        @media (prefers-reduced-motion: reduce) {
            .product-card { animation: none; }
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">

    <!-- HEADER -->
    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo Pharmacie" class="h-10 w-10 rounded-xl object-cover">
                    <span class="text-xl font-extrabold"><span style="color:var(--navy);">Pharma</span><span style="color:var(--brand);">Pro</span></span>
                </a>
                @auth
                    <div class="hidden sm:flex items-center gap-8 text-sm font-semibold">
                        <a href="{{ route('home') }}" style="color:var(--brand);">Accueil</a>
                        <a href="{{ route('client.commandes.index') }}" class="text-gray-700 hover:text-sky-700">Mes commandes</a>
                    </div>
                @endauth
            </div>

            <div class="flex items-center gap-3">
                <x-theme-toggle />
                @auth
                    <a href="{{ route('profile.edit') }}" class="iconbtn text-gray-700 hover:border-sky-300" title="Mon profil">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/><path d="M16 8 2 22"/><path d="M17.5 15H9"/></svg>
                    </a>
                    <a href="{{ route('client.commandes.index') }}" class="iconbtn text-gray-700 hover:border-sky-300 sm:hidden" title="Mes commandes">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-3V6a4 4 0 0 0-8 0v1H6a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8a1 1 0 0 0-1-1ZM9 6a3 3 0 0 1 6 0v1H9Z"/></svg>
                    </a>
                    <a href="{{ route('cart.index') }}" class="iconbtn relative" style="background:var(--sky-bg-2); border-color:var(--sky-border);" title="Panier">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--brand-hover)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        <span class="absolute -top-1.5 -right-1.5 bg-red-600 text-white text-[10px] font-bold w-[17px] h-[17px] rounded-full flex items-center justify-center" data-cart-count>
                            {{ count((array) session('cart')) }}
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-sky-700 font-semibold text-sm">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-pill btn-blue" style="padding:12px 24px;">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">{{ session('error') }}</div>
            @endif
        </div>
    @endif

    <!-- HERO -->
    <header class="text-center" style="background:linear-gradient(120deg,var(--hero-grad-1) 0%,var(--hero-grad-2) 55%,var(--hero-grad-3) 100%);">
        <div class="max-w-3xl mx-auto px-6 pt-16 pb-12">
            <div class="glass-pill inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold mb-5" style="color:var(--brand-hover);">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--brand-hover)" stroke-width="2.4"><path d="M12 22s8-4.5 8-11.8V5l-8-3-8 3v5.2C4 17.5 12 22 12 22Z"/></svg>
                Pharmacie agréée
            </div>
            <h1 class="text-4xl font-extrabold mb-4" style="color:var(--navy);">Vos médicaments, livrés en toute confiance</h1>
            <p class="mb-8 text-base" style="color:var(--navy-soft);">Trouvez vos médicaments, produits de bien-être et matériel médical, avec vérification pharmacien pour les ordonnances.</p>

            <form action="{{ route('home') }}" method="GET" class="glass-card rounded-2xl p-1.5 flex items-center gap-1 shadow-lg mb-8">
                <select name="categorie" class="border-none outline-none text-sm text-gray-600 py-2 pl-4 pr-2 bg-transparent font-semibold">
                    <option value="">Toutes catégories</option>
                    @foreach(\App\Models\Produit::CATEGORIES as $cat)
                        <option value="{{ $cat }}" {{ request('categorie') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <div class="w-px h-6 bg-gray-200 shrink-0"></div>
                <input type="text" name="search" placeholder="Rechercher un médicament, un symptôme..."
                       class="flex-1 border-none outline-none text-sm text-gray-700 py-2 px-3"
                       value="{{ request('search') }}">
                <button type="submit" class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:var(--brand);" title="Rechercher">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
            </form>

            <div class="flex items-center justify-center gap-3">
                <a href="#catalogue" class="btn-pill btn-navy">Voir le catalogue</a>
                @auth
                    <a href="{{ route('client.commandes.index') }}" class="btn-pill btn-outline">Mes commandes</a>
                @else
                    <a href="{{ route('register') }}" class="btn-pill btn-outline">Créer un compte</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- TRUST ICONS -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-9 grid grid-cols-1 sm:grid-cols-4 gap-6">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:var(--danger-bg);"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h6M9 12h6M9 16h4"/></svg></div>
                <div><div class="text-sm font-bold text-gray-900">Médicaments</div><div class="text-xs text-gray-500">Sur ordonnance et libres</div></div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:var(--success-bg);"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--success-strong)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-4.35-9.33-9A5.4 5.4 0 0 1 12 6a5.4 5.4 0 0 1 9.33 6C19 16.65 12 21 12 21Z"/></svg></div>
                <div><div class="text-sm font-bold text-gray-900">Bien-être</div><div class="text-xs text-gray-500">Vitamines, compléments</div></div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:var(--violet-bg);"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="10" width="18" height="8" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg></div>
                <div><div class="text-sm font-bold text-gray-900">Matériel médical</div><div class="text-xs text-gray-500">Tensiomètres, glycémie</div></div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0" style="background:var(--sky-bg-2);"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--brand-hover)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4.5 8-11.8V5l-8-3-8 3v5.2C4 17.5 12 22 12 22Z"/><path d="m9 12 2 2 4-4"/></svg></div>
                <div><div class="text-sm font-bold text-gray-900">Espace ordonnance</div><div class="text-xs text-gray-500">Dépôt et vérification</div></div>
            </div>
        </div>
    </div>

    <!-- CATEGORIES POPULAIRES -->
    <div class="max-w-6xl mx-auto px-6 py-14 w-full">
        <div class="text-center mb-8">
            <span class="text-xs font-bold uppercase tracking-widest" style="color:var(--brand);">Nos rayons</span>
            <h2 class="text-2xl font-extrabold text-gray-900 mt-1">Catégories populaires</h2>
        </div>

        @php
            $categoryStyles = [
                'Médicaments' => ['bg' => 'var(--sky-bg-1)', 'fg' => 'var(--blue-text)', 'icon' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h6M9 12h6M9 16h4"/>'],
                'Santé & Bien-être' => ['bg' => 'var(--success-bg)', 'fg' => 'var(--success-strong)', 'icon' => '<path d="M12 21s-7-4.35-9.33-9A5.4 5.4 0 0 1 12 6a5.4 5.4 0 0 1 9.33 6C19 16.65 12 21 12 21Z"/>'],
                'Hygiène & Soins' => ['bg' => 'var(--cyan-bg)', 'fg' => 'var(--cyan-text)', 'icon' => '<path d="M12 2s6 7 6 12a6 6 0 0 1-12 0c0-5 6-12 6-12Z"/>'],
                'Matériel Médical' => ['bg' => 'var(--violet-bg)', 'fg' => 'var(--violet)', 'icon' => '<rect x="3" y="10" width="18" height="8" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/>'],
                'Bébé & Maman' => ['bg' => 'var(--orange-bg)', 'fg' => 'var(--orange-text)', 'icon' => '<path d="M8 3v4M16 3v4M6 9h12l-1 5a5 5 0 0 1-10 0Z"/>'],
                'Cosmétiques' => ['bg' => 'var(--pink-bg)', 'fg' => 'var(--pink-text)', 'icon' => '<path d="M9 2h6M10 2v4.5L6.5 11A4 4 0 0 0 6 13v6a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-6a4 4 0 0 0-.5-2L14 6.5V2"/>'],
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categoryStyles as $cat => $style)
                <a href="{{ route('home', ['categorie' => $cat]) }}" class="cat-card items-center text-center" style="background:{{ $style['bg'] }};">
                    <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center mx-auto">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ $style['fg'] }}" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">{!! $style['icon'] !!}</svg>
                    </div>
                    <span class="text-sm font-bold" style="color:{{ $style['fg'] }};">{{ $cat }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <main id="catalogue" class="max-w-6xl mx-auto px-6 pb-14 flex-grow w-full">

        <div class="text-center mb-10">
            <span class="text-xs font-bold uppercase tracking-widest" style="color:var(--brand);">Notre catalogue</span>
            <h2 class="text-2xl font-extrabold text-gray-900 mt-1">{{ $produits->total() }} produit(s) disponible(s)</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($produits as $produit)
                <div class="product-card bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow p-4 flex flex-col">

                    <div class="relative h-36 rounded-xl overflow-hidden mb-3.5" style="background:var(--surface-alt);">
                        @if($produit->sur_ordonnance)
                            <span class="badge-pill absolute top-2 left-2" style="background:var(--danger-bg);color:var(--danger);border:1px solid var(--danger-border);">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2.6"><path d="M12 22s8-4.5 8-11.8V5l-8-3-8 3v5.2C4 17.5 12 22 12 22Z"/></svg>
                                Ordonnance
                            </span>
                        @endif
                        @if($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg width="46" height="46" viewBox="0 0 24 24" fill="none" stroke="var(--gray-icon)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h6M9 12h6M9 16h4"/></svg>
                            </div>
                        @endif
                    </div>

                    <span class="text-[11px] font-semibold" style="color:var(--brand);">{{ $produit->categorie }}</span>
                    <h3 class="text-sm font-bold text-gray-900 leading-tight mt-0.5 mb-2 h-9 overflow-hidden">{{ $produit->nom }}</h3>
                    <p class="text-xs text-gray-500 mb-3 h-8 overflow-hidden line-clamp-2 leading-relaxed">{{ $produit->description }}</p>

                    <div class="mt-auto">
                        <div class="font-extrabold text-gray-900 mb-2.5">{{ number_format($produit->prix, 0, ',', ' ') }} <span class="text-[11px] font-bold text-gray-500">FCFA</span></div>

                        @auth
                            <form action="{{ route('cart.add', $produit->id) }}" method="POST" data-cart-add>
                                @csrf
                                <button type="submit" class="btn-pill btn-blue w-full py-2.5">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                    Ajouter au panier
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-pill w-full py-2.5" style="background:var(--gray-bg-soft);color:var(--gray-text-2);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--gray-text-2)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                Se connecter pour acheter
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-gray-100">
                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--gray-icon)" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <p class="text-gray-500 text-lg font-medium mb-4">Aucun produit ne correspond à votre recherche.</p>
                    <a href="{{ route('home') }}" class="btn-pill btn-navy inline-flex">Voir tout le catalogue</a>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $produits->links() }}
        </div>
    </main>

    <footer class="text-white py-6" style="background:#0f2942;">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Pharmacie Aliou Baldé. Tous droits réservés.</p>
            <p class="text-sm mt-1" style="color:#93c5fd;">Votre santé, notre priorité.</p>
        </div>
    </footer>

</body>
</html>
