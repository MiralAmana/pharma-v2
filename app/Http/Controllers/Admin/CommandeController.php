<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Notifications\CommandeStatutMisAJour;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    // 1. VOIR LA LISTE DES COMMANDES
    public function index()
    {
        $commandes = Commande::with(['user', 'lignes.produit', 'traitePar'])->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.commandes.index', compact('commandes'));
    }

    // 2. VALIDER LA COMMANDE
    public function valider($id)
    {
        $commande = DB::transaction(function () use ($id) {
            // Verrou sur la commande et les produits concernés le temps de la transaction,
            // pour éviter qu'une validation concurrente ne déduise le stock deux fois.
            $commande = Commande::with('lignes')->lockForUpdate()->findOrFail($id);

            if ($commande->statut === 'validée') {
                return null;
            }

            foreach ($commande->lignes as $ligne) {
                $produit = Produit::lockForUpdate()->find($ligne->produit_id);
                if ($produit && $produit->stock >= $ligne->quantite) {
                    $produit->decrement('stock', $ligne->quantite);
                }
            }

            $commande->statut = 'validée';
            $commande->traite_par_id = Auth::id();
            $commande->traite_le = now();
            $commande->save();

            return $commande;
        });

        if (! $commande) {
            return back()->with('error', 'Déjà validée.');
        }

        $commande->user->notify(new CommandeStatutMisAJour($commande));

        return back()->with('success', 'Commande validée !');
    }

    // 3. ANNULER UNE COMMANDE (ET REMETTRE EN STOCK SI NÉCESSAIRE)
    public function annuler($id)
    {
        $commande = DB::transaction(function () use ($id) {
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
            $commande->traite_par_id = Auth::id();
            $commande->traite_le = now();
            $commande->save();

            return $commande;
        });

        $commande->user->notify(new CommandeStatutMisAJour($commande));

        return back()->with('success', 'Commande annulée ');
    }
}
