<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;

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
        $commande = Commande::with('lignes')->findOrFail($id);

        if($commande->statut === 'validée') {
            return back()->with('error', 'Déjà validée.');
        }

        // Gestion du stock
        foreach($commande->lignes as $ligne) {
            $produit = Produit::find($ligne->produit_id);
            if($produit && $produit->stock >= $ligne->quantite) {
                $produit->stock -= $ligne->quantite;
                $produit->save();
            }
        }

        $commande->statut = 'validée';
        $commande->save();

        return back()->with('success', 'Commande validée !');
    }

    // 3. ANNULER LA COMMANDE
    // 3. ANNULER UNE COMMANDE (ET REMETTRE EN STOCK SI NÉCESSAIRE)
    public function annuler($id)
    {
        $commande = Commande::with('lignes')->findOrFail($id);

        // Si la commande était DÉJÀ validée, cela veut dire qu'on avait déjà déduit le stock.
        // Il faut donc le REMETTRE (Ré-incrémenter).
        if($commande->statut === 'validée') {
            foreach($commande->lignes as $ligne) {
                $produit = Produit::find($ligne->produit_id);
                if($produit) {
                    $produit->stock += $ligne->quantite; // On rajoute le stock
                    $produit->save();
                }
            }
        }

        $commande->statut = 'annulée';
        $commande->save();

        return back()->with('success', 'Commande annulée ');
    }
}