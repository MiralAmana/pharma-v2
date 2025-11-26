<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\CatalogueController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\ProduitController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // --- ROUTES DU PANIER ---
    // Voir le panier
    Route::get('/mon-panier', [CartController::class, 'index'])->name('cart.index');
    
    // Ajouter un produit (on passe l'ID dans l'URL)
    Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    
    // Supprimer un produit
    Route::get('/remove-from-cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout/valider', [CheckoutController::class, 'valider'])->name('checkout.valider');

    // --- ESPACE GÉRANT (DASHBOARD) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // --- GESTION DES COMMANDES ---
    Route::get('/admin/commandes', [CommandeController::class, 'index'])->name('admin.commandes');
    Route::get('/admin/commandes/{id}/valider', [CommandeController::class, 'valider'])->name('admin.valider');
    Route::get('/admin/commandes/{id}/annuler', [CommandeController::class, 'annuler'])->name('admin.annuler');
    // --- GESTION DES PRODUITS ---
    Route::get('/admin/produits', [ProduitController::class, 'index'])->name('admin.produits.index');
    Route::get('/admin/produits/create', [ProduitController::class, 'create'])->name('admin.produits.create');
    Route::post('/admin/produits', [ProduitController::class, 'store'])->name('admin.produits.store');
    Route::delete('/admin/produits/{id}', [ProduitController::class, 'destroy'])->name('admin.produits.destroy');
    Route::get('/admin/produits/{id}/edit', [ProduitController::class, 'edit'])->name('admin.produits.edit');
    Route::put('/admin/produits/{id}', [ProduitController::class, 'update'])->name('admin.produits.update');
    
});
Route::get('/', [CatalogueController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
