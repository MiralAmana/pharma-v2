<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Compter les produits
        $totalProduits = Produit::count();

        // 2. Compter les commandes en attente (C'est urgent pour le gérant)
        $commandesEnAttente = Commande::where('statut', 'en_attente')->count();

        // 3. Chiffre d'affaires total (des commandes validées uniquement)
        $chiffreAffaires = Commande::where('statut', 'validée')->sum('total');

        // 4. Alerte Stock (Produits avec moins de 5 unités)
        $alerteStock = Produit::where('stock', '<', 5)->count();

        return view('admin.dashboard', compact('totalProduits', 'commandesEnAttente', 'chiffreAffaires', 'alerteStock'));
    }
}