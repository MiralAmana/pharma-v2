# Audit — pharma-v2

Date : 2026-08-29
Stack : Laravel 12 / PHP 8.2, PostgreSQL, Breeze (auth), Blade + Tailwind (CDN)

Périmètre : contrôleurs, modèles, routes, middlewares, vues, config. Pas de scan de dépendances (`composer audit`) ni de tests d'intrusion actifs — analyse statique du code source.

---

## 🔴 Critique

### 1. ✅ CORRIGÉ — Upload d'ordonnance non validé, dans un dossier public, exécutable
[CheckoutController.php](app/Http/Controllers/Client/CheckoutController.php), [OrdonnanceController.php](app/Http/Controllers/OrdonnanceController.php)

Ancien code :
```php
$file = $request->file('ordonnance');
$filename = time() . '_' . $file->getClientOriginalName();
$file->move(public_path('ordonnances'), $filename);
```

- Aucune validation serveur — l'attribut HTML `accept="image/*,.pdf"` côté client ne protège rien, un attaquant envoie n'importe quel fichier via une requête forgée.
- Le nom de fichier original n'était pas assaini : `getClientOriginalName()` était concaténé tel quel. Un nom comme `shell.php` aboutissait dans `public/ordonnances/xxxx_shell.php`, un dossier servi directement par le webserveur → **exécution de code arbitraire** si PHP est autorisé à s'exécuter dans ce dossier.
- Même sans RCE, l'absence de restriction de type permettait de stocker des fichiers arbitraires (déni de service par remplissage disque, contenu illicite hébergé sous le nom de domaine de la pharmacie).

**Correctif appliqué** :
- Validation serveur ajoutée : `'ordonnance' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120']` ([CheckoutController.php:21-23](app/Http/Controllers/Client/CheckoutController.php#L21-L23)).
- Nom de fichier généré aléatoirement (`Str::uuid()`), le nom original n'est plus utilisé.
- Stockage déplacé du disque public vers le disque `local` (`storage/app/private`, non servi par le webserveur) via `$file->storeAs('ordonnances', $filename, 'local')`.
- Nouveau contrôleur [OrdonnanceController.php](app/Http/Controllers/OrdonnanceController.php) + route `ordonnances.show` (groupe `auth`) qui vérifie que l'utilisateur est le propriétaire de la commande ou un gérant avant de streamer le fichier (`Storage::disk('local')->response(...)`), sinon `403`.
- Le lien dans la vue admin ([admin/commandes/index.blade.php](resources/views/admin/commandes/index.blade.php)) pointe maintenant vers `route('ordonnances.show', $commande->id)` au lieu de `asset(...)`.
- Les 4 fichiers déjà présents dans `public/ordonnances/` (données réelles déjà exposées) ont été déplacés vers `storage/app/private/ordonnances/` avec le même chemin relatif, donc les anciennes commandes restent consultables via la nouvelle route protégée ; `public/ordonnances/` a été supprimé.

Ceci résout également le point 2 ci-dessous (même cause racine).

### 2. ✅ CORRIGÉ — Ordonnances médicales accessibles publiquement sans authentification
[admin/commandes/index.blade.php](resources/views/admin/commandes/index.blade.php)

- Le fichier était servi depuis `public/ordonnances/`, donc **toute personne connaissant ou devinant l'URL** pouvait consulter le document médical d'un client, sans être connectée. Le préfixe `time()` était prévisible (secondes Unix au moment de l'upload) et brute-forçable sur une courte fenêtre.
- Il s'agit d'une donnée de santé (prescription médicale) — la fuite était particulièrement sensible.

**Correctif appliqué** : voir point 1 — stockage hors du disque public, accès exclusivement via la route `ordonnances.show` protégée par `auth` + vérification propriétaire/gérant dans [OrdonnanceController.php](app/Http/Controllers/OrdonnanceController.php).

---

## 🟠 Élevé

### 3. ✅ CORRIGÉ — Actions d'état critiques exposées en GET (CSRF via lien/image)
[routes/web.php](routes/web.php)

Ancien code :
```php
Route::get('/admin/commandes/{id}/valider', ...)->name('admin.valider');
Route::get('/admin/commandes/{id}/annuler', ...)->name('admin.annuler');
Route::get('/add-to-cart/{id}', ...)->name('cart.add');
Route::get('/remove-from-cart/{id}', ...)->name('cart.remove');
```

Le middleware CSRF de Laravel ne protège que POST/PUT/PATCH/DELETE. Ces routes GET modifiaient de l'état (valide une commande et décrémente le stock, annule une commande et réincrémente le stock, modifie le panier) et étaient donc :
- Vulnérables au CSRF classique (une balise `<img src="https://site/admin/commandes/12/annuler">` sur une page tierce, visitée par un gérant connecté, annulait silencieusement une commande) ;
- Déclenchables par des robots/crawlers ou le prefetching de navigateur, qui suivent les liens GET.

**Correctif appliqué** :
- `admin.valider` / `admin.annuler` / `cart.add` passés en `Route::post`, `cart.remove` en `Route::delete`.
- Les liens `<a href="...">` correspondants ([admin/commandes/index.blade.php](resources/views/admin/commandes/index.blade.php), [welcome.blade.php](resources/views/welcome.blade.php), [client/cart.blade.php](resources/views/client/cart.blade.php)) remplacés par des `<form method="POST">` avec `@csrf` (et `@method('DELETE')` pour le retrait du panier).
- Vérifié en conditions réelles dans le navigateur : ajout au panier, retrait, et validation d'une commande admin fonctionnent tous via leur nouvelle méthode HTTP protégée par CSRF.

### 4. ✅ CORRIGÉ — Middleware `IsAdmin` : pas de garde-fou si l'utilisateur est null
[IsAdmin.php](app/Http/Middleware/IsAdmin.php)

Ancien code :
```php
if (auth()->user()->role !== 'gerant') {
```

Ne fonctionnait que parce que la route était toujours combinée avec `auth` avant `admin` dans le groupe de `web.php`. Si ce middleware était un jour réutilisé seul (nouvelle route, API, etc.), `auth()->user()` retournerait `null` et l'appel `->role` lèverait une erreur fatale au lieu d'un rejet propre.

**Correctif appliqué** : `if (! auth()->check() || auth()->user()->role !== 'gerant')` — le middleware rejette proprement (redirection) même sans utilisateur authentifié, quel que soit le contexte d'appel.

Reste non traité : un refus renvoie toujours `redirect('/')` (HTTP 302) plutôt qu'un `abort(403)` — acceptable pour l'UX web actuelle, mais à revoir si une API est ajoutée un jour.

---

## 🟡 Moyen

### 5. ✅ CORRIGÉ — Validation de commande : lecture non verrouillée du stock (race condition)
[CommandeController.php](app/Http/Controllers/Admin/CommandeController.php)

Ancien code :
```php
if($produit && $produit->stock >= $ligne->quantite) {
    $produit->stock -= $ligne->quantite;
    $produit->save();
}
```

Pas de verrou (`lockForUpdate()`) ni de transaction DB autour de la lecture/écriture du stock. Deux validations concurrentes sur des commandes qui portent sur le même produit pouvaient produire un stock incohérent (ou négatif si l'ordre des opérations se chevauchait).

**Correctif appliqué** : `valider()` et `annuler()` enveloppent désormais toute la logique dans `DB::transaction()`, avec `lockForUpdate()` sur la commande et sur chaque produit concerné avant lecture/écriture du stock (`increment()`/`decrement()` plutôt que lecture-puis-`save()`). Deux appels concurrents sur la même commande ou le même produit sont désormais sérialisés par le verrou de ligne PostgreSQL au lieu de se marcher dessus.

Vérifié en conditions réelles : commande créée → validée (stock Gaviscon Menthe 39 → 38 en base) → statut passé à "Validée" dans l'interface.

Non traité (hors scope de ce point) : le bouton "Annuler" n'est affiché dans la vue que pour les commandes `en_attente` — `annuler()` sur une commande déjà validée n'est donc pas atteignable depuis l'interface actuelle, bien que le contrôleur le gère correctement.

### 6. ✅ CORRIGÉ — `ILIKE` codé en dur — dépendance à PostgreSQL
[CatalogueController.php](app/Http/Controllers/Client/CatalogueController.php)

`ILIKE` est spécifique à PostgreSQL. Si la stack change un jour de SGBD (MySQL, SQLite en tests...), cette requête échouerait.

**Correctif appliqué** : remplacé par `whereRaw('LOWER(nom) LIKE ?', ['%'.mb_strtolower($request->search).'%'])`, portable entre SGBD tout en gardant une recherche insensible à la casse. Vérifié en conditions réelles : recherche `gaviscon` et `TRAMADOL` (casses différentes) retournent bien les bons produits.

### 7. ✅ CORRIGÉ — `$request->all()` passé directement à `create()`/`update()`
[ProduitController.php](app/Http/Controllers/Admin/ProduitController.php)

Protégé par le `$fillable` du modèle `Produit` donc pas d'assignation de masse dangereuse dans l'état antérieur, mais pratique fragile en cas d'ajout futur d'un champ sensible à `$fillable`.

**Correctif appliqué** : `store()` et `update()` utilisent désormais directement le tableau retourné par `$request->validate([...])` (règle `description` ajoutée à la liste, absente à tort auparavant) au lieu de `$request->all()`. Vérifié en conditions réelles : création et modification d'un produit fonctionnent, seuls les champs validés sont persistés.

### 8. ✅ CORRIGÉ — Tailwind chargé depuis un CDN externe
[client/cart.blade.php](resources/views/client/cart.blade.php)

`<script src="https://cdn.tailwindcss.com">` — dépendance à un tiers non versionné, sans Subresource Integrity, alors que le reste du projet utilise Vite (`@vite(...)`).

**Correctif appliqué** : remplacé par `@vite(['resources/css/app.css', 'resources/js/app.js'])`, cohérent avec le reste de l'app (`tailwind.config.js` couvre déjà `resources/views/**/*.blade.php`). Vérifié en conditions réelles : la page panier s'affiche correctement stylée sans requête vers le CDN.

---

## 🔵 Découvert pendant les vérifications

### 9. ✅ CORRIGÉ — Formulaire d'édition produit : le champ Date de Péremption arrivait vide
[admin/produits/edit.blade.php](resources/views/admin/produits/edit.blade.php), [admin/produits/create.blade.php](resources/views/admin/produits/create.blade.php)

Ancien code :
```php
<input type="date" name="date_peremption" value="{{ $produit->date_peremption }}" ...>
```

`date_peremption` est casté en `date` (Carbon) sur le modèle `Produit`. Sa conversion implicite en chaîne (`{{ }}`) produisait un format `Y-m-d H:i:s`, alors qu'un `<input type="date">` HTML5 n'accepte que `Y-m-d` — le navigateur rejetait la valeur et affichait le champ vide. Résultat : à chaque édition, si l'admin ne re-saisissait pas manuellement la date, la validation `date_peremption => required|date` échouait et **la modification entière était silencieusement rejetée** (aucune erreur visible, confirmé en testant : un changement de prix seul, sans retoucher la date, n'était pas enregistré).

**Correctif appliqué** :
- `edit.blade.php` : `value="{{ old('date_peremption', $produit->date_peremption?->format('Y-m-d')) }}"` — format compatible avec l'input HTML5.
- `create.blade.php` et `edit.blade.php` : ajout d'un bloc d'affichage de `$errors` (`@if ($errors->any())`) en tête de formulaire, absent jusqu'ici — toute erreur de validation (pas seulement celle-ci) est désormais visible pour l'admin.
- Tous les champs des deux formulaires utilisent maintenant `old('champ', $produit->champ)` pour ne pas perdre la saisie de l'admin en cas d'erreur de validation sur un autre champ.

Vérifié en conditions réelles : édition du prix d'un produit existant sans retoucher la date → sauvegarde réussie (1200 → 1250 FCFA) ; soumission d'un formulaire vide → bloc d'erreurs affiché avec le détail de chaque champ manquant.

---

## 🟢 Points positifs

- **Portée des commandes client correctement isolée** : [MesCommandesController.php:14](app/Http/Controllers/Client/MesCommandesController.php#L14) filtre bien par `Auth::id()`, pas d'IDOR sur l'historique de commandes.
- **Inscription** : le rôle est forcé côté serveur à `'client'` ([RegisteredUserController.php:46](app/Http/Controllers/Auth/RegisteredUserController.php#L46)), pas d'auto-élévation possible en `gerant` via un champ de formulaire.
- **Modèles avec `$fillable` explicites** (`Produit`, `User`, `Commande`, `LigneCommande`) — pas d'assignation de masse ouverte.
- **Mot de passe hashé** (`Hash::make`, cast `'password' => 'hashed'`), champs sensibles dans `$hidden`.
- **CSRF correctement en place** sur le formulaire de checkout (`@csrf` présent).
- **`.env` non versionné**, `.gitignore` correct, `.env.example` sans secret réel.
- **Suppression de produit en soft delete** (`SoftDeletes` sur `Produit`, `LigneCommande::produit()` utilise `withTrashed()`) — l'historique des commandes reste cohérent même si un produit est retiré du catalogue.

---

## Priorités recommandées

1. ~~Corriger l'upload d'ordonnance (validation + stockage privé + accès authentifié)~~ — **fait le 2026-08-29**.
2. ~~Passer les routes `admin.valider` / `admin.annuler` / `cart.add` / `cart.remove` en méthodes HTTP appropriées avec CSRF~~ — **fait le 2026-08-29**.
3. ~~Sécuriser `IsAdmin` contre un `auth()->user()` null~~ — **fait le 2026-08-29**.
4. ~~Ajouter une transaction + verrou sur la déduction de stock~~ — **fait le 2026-08-29**.
5. ~~`ILIKE` → recherche portable, `$request->all()` → `validate()`, Tailwind CDN → Vite~~ — **fait le 2026-08-29**.
6. ~~Corriger le format de `date_peremption` + afficher `$errors` dans les formulaires produit~~ — **fait le 2026-08-29**.

Tous les points identifiés dans cet audit sont corrigés et vérifiés en conditions réelles.

---

## Critique générale du projet (au-delà de la sécurité) — corrigée le 2026-08-29

Une revue plus large (architecture, tests, logique métier) a identifié et corrigé les points suivants :

### ✅ Suite de tests réellement cassée
3 des 25 tests échouaient en pratique (vérifié par exécution) :
- `RegistrationTest` postait sans `telephone`/`adresse`, désormais requis par [RegisteredUserController.php](app/Http/Controllers/Auth/RegisteredUserController.php) → **corrigé** : le test envoie ces champs.
- `AuthenticationTest` attendait une redirection vers `/dashboard`, alors qu'un client (rôle par défaut) est redirigé vers `/` → **corrigé** : assertion mise à jour vers `route('home')`, et un test `test_gerant_is_redirected_to_dashboard` ajouté pour couvrir l'autre branche.
- `ExampleTest` plantait sur `no such table: produits` (pas de migrations) → **corrigé** : ajout de `RefreshDatabase`.

**26/26 tests passent désormais** ([tests/Feature/Auth/AuthenticationTest.php](tests/Feature/Auth/AuthenticationTest.php), [RegistrationTest.php](tests/Feature/Auth/RegistrationTest.php), [ExampleTest.php](tests/Feature/ExampleTest.php)). La CI (`.github/workflows/tests.yml`) devrait maintenant être verte.

### ✅ CDN Tailwind restant sur 4 pages
L'audit initial n'avait corrigé que `client/cart.blade.php`. Retiré aussi de [profile/edit.blade.php](resources/views/profile/edit.blade.php), [client/commandes/index.blade.php](resources/views/client/commandes/index.blade.php), [client/success.blade.php](resources/views/client/success.blade.php) et [admin/dashboard.blade.php](resources/views/admin/dashboard.blade.php) (`@vite` partout).

### ✅ `admin/dashboard.blade.php` reconstruit sur le layout partagé
Était une page HTML autonome dupliquant nav/déconnexion. Utilise maintenant `<x-app-layout>` comme les autres pages admin ; ajout des liens "Commandes"/"Produits" dans [layouts/navigation.blade.php](resources/views/layouts/navigation.blade.php) (visible uniquement par les gérants, seuls utilisateurs de ce layout).

### ✅ Catégories centralisées
Constante `Produit::CATEGORIES` ([Produit.php](app/Models/Produit.php)) — source unique utilisée par `welcome.blade.php` et les `<select>` de `create.blade.php`/`edit.blade.php`, qui codaient chacun leur propre liste.

### ✅ Validation `ProduitController` déplacée dans des `FormRequest`
[StoreProduitRequest.php](app/Http/Requests/StoreProduitRequest.php) et [UpdateProduitRequest.php](app/Http/Requests/UpdateProduitRequest.php), cohérents avec le reste de l'app (`LoginRequest`, `ProfileUpdateRequest`). La catégorie est désormais validée contre `Produit::CATEGORIES` (`Rule::in`).

### ✅ Aucune vérification de stock à l'ajout au panier
[CartController::addToCart](app/Http/Controllers/Client/CartController.php) refuse désormais d'ajouter au-delà du stock disponible, avec message d'erreur explicite. Vérifié : 4 clics sur un produit à stock 3 → quantité plafonnée à 3, message "Stock insuffisant" affiché.

### ✅ Pas de revérification stock/prix au checkout
[CheckoutController::valider](app/Http/Controllers/Client/CheckoutController.php) revérifie désormais le stock et recalcule le total à partir des prix actuels en base (au lieu du prix figé en session au moment de l'ajout au panier). L'exigence d'ordonnance pour un produit concerné est aussi désormais vérifiée côté serveur (`required` conditionnel), pas seulement côté client.

### ✅ Panier sans gestion de quantité
Ajout de boutons +/- dans [client/cart.blade.php](resources/views/client/cart.blade.php) et d'une route/méthode `cart.decrease` ([CartController::decrease](app/Http/Controllers/Client/CartController.php)).

### ✅ Logique métier dans les vues (violation MVC)
Le calcul `needsPrescription` (`\App\Models\Produit::find()` dans une boucle `@php`) a été déplacé de `cart.blade.php` vers `CartController::index()` et `CheckoutController::valider()`.

### ✅ Détail des commandes invisible pour l'admin
[admin/commandes/index.blade.php](resources/views/admin/commandes/index.blade.php) affiche désormais la liste des produits/quantités de chaque commande (`Commande::with(['user', 'lignes.produit'])`), plus seulement le total.

### ✅ Messages flash absents sur la page d'accueil
`welcome.blade.php` n'affichait aucun message de succès/erreur (découvert en testant le refus de stock) — bannière ajoutée, cohérente avec les autres pages.

### ✅ Aucun test métier — 35 tests ajoutés
Créé les factories manquantes ([ProduitFactory](database/factories/ProduitFactory.php), [CommandeFactory](database/factories/CommandeFactory.php), [LigneCommandeFactory](database/factories/LigneCommandeFactory.php) — `Commande` n'avait même pas `HasFactory`) et 7 fichiers de tests couvrant le cœur métier :
- [CatalogueTest.php](tests/Feature/CatalogueTest.php) — filtre stock, recherche insensible à la casse, filtre catégorie, badge ordonnance.
- [CartTest.php](tests/Feature/CartTest.php) — accès invité bloqué, ajout, incrément, plafond de stock, décrément, retrait.
- [CheckoutTest.php](tests/Feature/CheckoutTest.php) — panier vide, total correct, **prix recalculé depuis la base (pas la session)**, stock insuffisant bloqué, ordonnance obligatoire, fichier accepté, panier vidé après validation.
- [Admin/ProduitManagementTest.php](tests/Feature/Admin/ProduitManagementTest.php) — accès client/invité bloqué, CRUD complet, catégorie invalide rejetée, soft delete.
- [Admin/CommandeManagementTest.php](tests/Feature/Admin/CommandeManagementTest.php) — accès client bloqué, déduction de stock à la validation, **double-validation ne déduit qu'une fois**, réintégration du stock à l'annulation (commande validée vs en attente).
- [OrdonnanceAccessTest.php](tests/Feature/OrdonnanceAccessTest.php) — propriétaire autorisé, autre client refusé (403), gérant autorisé, invité redirigé.
- [MesCommandesTest.php](tests/Feature/MesCommandesTest.php) — un client ne voit que ses propres commandes.

**61/61 tests passent** (26 scaffold + 35 métier). Vérifié aussi que `UploadedFile::fake()->image()` nécessite l'extension GD (absente localement et en CI) — utilisé `->create()` à la place pour ne pas dépendre de GD.

### Non traité (signalé, pas corrigé)
- **Deux workflows CI redondants** : [laravel.yml](.github/workflows/laravel.yml) ne fait qu'un `php artisan about` sans lancer les tests, en plus de [tests.yml](.github/workflows/tests.yml) qui les lance réellement — à consolider.
- **Pas de pagination** sur le catalogue, la liste produits admin, ni les commandes (client/admin) — non bloquant au volume actuel.
- **`resources/views/dashboard.blade.php`** (scaffold Breeze par défaut) n'est plus jamais rendu depuis que la route `dashboard` pointe vers `DashboardController` — fichier mort, à supprimer si confirmé inutile.
