<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\CatalogueController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
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
});
Route::get('/', [CatalogueController::class, 'index'])->name('home');
require __DIR__.'/auth.php';
