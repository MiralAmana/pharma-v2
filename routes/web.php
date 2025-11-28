<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\CatalogueController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Client\MesCommandesController;

// 1. PAGE D'ACCUEIL (Accessible à tout le monde)
Route::get('/', [CatalogueController::class, 'index'])->name('home');

// 2. GROUPE POUR TOUS LES UTILISATEURS CONNECTÉS (Clients + Gérants)
Route::middleware('auth')->group(function () {
    
    // Profil (Par défaut Laravel)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- FONCTIONNALITÉS CLIENT ---
    // Panier
    Route::get('/mon-panier', [CartController::class, 'index'])->name('cart.index');
    Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/remove-from-cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Validation Commande
    Route::post('/checkout/valider', [CheckoutController::class, 'valider'])->name('checkout.valider');

    // Suivi des commandes (Historique Client)
    Route::get('/mes-commandes', [MesCommandesController::class, 'index'])->name('client.commandes.index');
});

// 3. GROUPE SÉCURISÉ POUR LE GÉRANT UNIQUEMENT
// On utilise le middleware 'admin' pour bloquer les clients
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des Commandes
    Route::get('/admin/commandes', [CommandeController::class, 'index'])->name('admin.commandes');
    Route::get('/admin/commandes/{id}/valider', [CommandeController::class, 'valider'])->name('admin.valider');
    Route::get('/admin/commandes/{id}/annuler', [CommandeController::class, 'annuler'])->name('admin.annuler');

    // Gestion des Produits
    Route::get('/admin/produits', [ProduitController::class, 'index'])->name('admin.produits.index');
    Route::get('/admin/produits/create', [ProduitController::class, 'create'])->name('admin.produits.create');
    Route::post('/admin/produits', [ProduitController::class, 'store'])->name('admin.produits.store');
    Route::get('/admin/produits/{id}/edit', [ProduitController::class, 'edit'])->name('admin.produits.edit');
    Route::put('/admin/produits/{id}', [ProduitController::class, 'update'])->name('admin.produits.update');
    Route::delete('/admin/produits/{id}', [ProduitController::class, 'destroy'])->name('admin.produits.destroy');

});

require __DIR__.'/auth.php';