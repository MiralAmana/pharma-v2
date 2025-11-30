<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. CHIFFRES CLÉS BASIQUES
        $totalProduits = Produit::count();
        $commandesEnAttente = Commande::where('statut', 'en_attente')->count();
        $chiffreAffaires = Commande::where('statut', 'validée')->sum('total');
        
        // 2. ALERTES STOCK (Quantité < 5)
        $alerteStock = Produit::where('stock', '<', 5)->count();

        // 3. ALERTES PÉREMPTION (Périme dans moins de 3 mois) - NOUVEAU !
        // On cherche les produits dont la date est entre aujourd'hui et dans 90 jours
        $alertePeremption = Produit::whereDate('date_peremption', '<', Carbon::now()->addMonths(3))
                                   ->whereDate('date_peremption', '>', Carbon::now()) // Pas encore périmés, mais bientôt
                                   ->get();

        // 4. PRODUITS PHARES (TOP 5 des ventes) - NOUVEAU !
        $topProduits = LigneCommande::select('produit_id', DB::raw('SUM(quantite) as total_vendus'))
            ->groupBy('produit_id')
            ->orderByDesc('total_vendus')
            ->limit(5)
            ->with('produit') // On charge les infos du produit
            ->get();

        return view('admin.dashboard', compact(
            'totalProduits', 
            'commandesEnAttente', 
            'chiffreAffaires', 
            'alerteStock',
            'alertePeremption',
            'topProduits'
        ));
    }
}