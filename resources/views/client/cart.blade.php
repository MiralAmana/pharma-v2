<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .btn-pill { display:inline-flex; align-items:center; justify-content:center; gap:8px; border-radius:999px; font-weight:700; font-size:14px; cursor:pointer; border:none; }
        .btn-blue { background:#0284c7; color:#fff; padding:14px 26px; }
        .btn-blue:hover { background:#0369a1; }
        .iconbtn { width:38px; height:38px; border-radius:999px; border:1.5px solid #e5e7eb; display:flex; align-items:center; justify-content:center; }
        .badge-pill { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
        .stepbtn { width:28px; height:28px; border-radius:8px; border:1.5px solid #e5e7eb; background:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; color:#374151; }
    </style>
</head>
<body class="bg-gray-50" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">

    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.jpg') }}" alt="Logo Pharmacie" class="h-10 w-10 rounded-xl object-cover">
                <span class="text-xl font-extrabold text-gray-900">PharmaPro</span>
            </a>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-sky-700 flex items-center gap-1.5">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Retour aux achats
            </a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-extrabold text-gray-900 mb-8">Mon panier</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-7 items-start">

            <div class="lg:col-span-2 flex flex-col gap-3.5">
                @forelse($cart as $id => $details)
                    @php $totalLigne = $details['price'] * $details['quantity']; @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0" style="background:#f7f8f7;">
                            @if(!empty($details['image']))
                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h6M9 12h6M9 16h4"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm truncate">{{ $details['name'] }}</div>
                            @if(in_array($id, $idsSurOrdonnance))
                                <span class="badge-pill mt-1" style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="2.4"><path d="M12 22s8-4.5 8-11.8V5l-8-3-8 3v5.2C4 17.5 12 22 12 22Z"/></svg>
                                    Ordonnance requise
                                </span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-500 w-24 text-right shrink-0">{{ number_format($details['price'], 0, ',', ' ') }} FCFA</div>
                        <div class="flex items-center gap-2 shrink-0">
                            <form action="{{ route('cart.decrease', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="stepbtn" title="Diminuer">−</button>
                            </form>
                            <span class="w-5 text-center text-sm font-bold">{{ $details['quantity'] }}</span>
                            <form action="{{ route('cart.add', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="stepbtn" title="Augmenter">+</button>
                            </form>
                        </div>
                        <div class="font-extrabold text-sky-700 w-24 text-right shrink-0">{{ number_format($totalLigne, 0, ',', ' ') }} FCFA</div>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Retirer" class="text-gray-400 hover:text-red-600">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-500">
                        Votre panier est vide pour le moment.
                    </div>
                @endforelse
            </div>

            @if(!empty($cart))
                @php $totalGlobal = collect($cart)->sum(fn($d) => $d['price'] * $d['quantity']); @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:sticky lg:top-6">
                    <h2 class="font-extrabold text-gray-900 mb-4">Récapitulatif</h2>
                    <div class="flex justify-between text-sm text-gray-600 mb-3">
                        <span>Sous-total ({{ count($cart) }} article(s))</span>
                        <span class="font-semibold text-gray-900">{{ number_format($totalGlobal, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span>Livraison</span>
                        <span class="font-semibold text-sky-700">Calculée à la remise</span>
                    </div>
                    <div class="h-px bg-gray-100 mb-4"></div>
                    <div class="flex justify-between items-baseline mb-5">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="text-2xl font-extrabold text-sky-700">{{ number_format($totalGlobal, 0, ',', ' ') }} <span class="text-xs">FCFA</span></span>
                    </div>

                    <form action="{{ route('checkout.valider') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if($needsPrescription)
                            <div class="mb-4 text-left bg-red-50 p-4 rounded-xl border border-red-200">
                                <label class="flex items-center gap-2 text-red-700 font-bold mb-2 text-sm">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="2"><path d="M12 22s8-4.5 8-11.8V5l-8-3-8 3v5.2C4 17.5 12 22 12 22Z"/></svg>
                                    Ordonnance requise
                                </label>
                                <p class="text-xs text-gray-600 mb-3">Votre panier contient un médicament sur ordonnance. Merci de joindre une photo ou un scan pour continuer.</p>
                                <input type="file" name="ordonnance" accept="image/*,.pdf" required
                                       class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                            </div>
                        @endif

                        <button type="submit" class="btn-pill btn-blue w-full">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V8a5 5 0 0 1 10 0v3"/></svg>
                            Valider la commande
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</body>
</html>
