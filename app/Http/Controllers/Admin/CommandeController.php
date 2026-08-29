<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    // 1. VOIR LA LISTE DES COMMANDES
    public function index()
    {
        $commandes = Commande::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.commandes.index', compact('commandes'));
    }

    // 2. VALIDER LA COMMANDE
    public function valider($id)
    {
        $dejaValidee = DB::transaction(function () use ($id) {
            // Verrou sur la commande et les produits concernés le temps de la transaction,
            // pour éviter qu'une validation concurrente ne déduise le stock deux fois.
            $commande = Commande::with('lignes')->lockForUpdate()->findOrFail($id);

            if ($commande->statut === 'validée') {
                return true;
            }

            foreach ($commande->lignes as $ligne) {
                $produit = Produit::lockForUpdate()->find($ligne->produit_id);
                if ($produit && $produit->stock >= $ligne->quantite) {
                    $produit->decrement('stock', $ligne->quantite);
                }
            }

            $commande->statut = 'validée';
            $commande->save();

            return false;
        });

        if ($dejaValidee) {
            return back()->with('error', 'Déjà validée.');
        }

        return back()->with('success', 'Commande validée !');
    }

    // 3. ANNULER UNE COMMANDE (ET REMETTRE EN STOCK SI NÉCESSAIRE)
    public function annuler($id)
    {
        DB::transaction(function () use ($id) {
            $commande = Commande::with('lignes')->lockForUpdate()->findOrFail($id);

            // Si la commande était DÉJÀ validée, cela veut dire qu'on avait déjà déduit le stock.
            // Il faut donc le REMETTRE (Ré-incrémenter).
            if ($commande->statut === 'validée') {
                foreach ($commande->lignes as $ligne) {
                    $produit = Produit::lockForUpdate()->find($ligne->produit_id);
                    if ($produit) {
                        $produit->increment('stock', $ligne->quantite);
                    }
                }
            }

            $commande->statut = 'annulée';
            $commande->save();
        });

        return back()->with('success', 'Commande annulée ');
    }
}