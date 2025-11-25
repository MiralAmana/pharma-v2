<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function valider()
    {
        $cart = session()->get('cart');

        // 1. Vérifier si panier vide
        if(!$cart) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // 2. Calcul du total
        $total = 0;
        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // 3. Création de la commande
        $commande = Commande::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'statut' => 'en_attente',
            'reference' => 'CMD-' . strtoupper(Str::random(6)), // Ex: CMD-X7Y2Z1
        ]);

        // 4. Enregistrement des lignes (Détails)
        foreach($cart as $id => $details) {
            LigneCommande::create([
                'commande_id' => $commande->id,
                'produit_id' => $id,
                'quantite' => $details['quantity'],
                'prix_unitaire' => $details['price']
            ]);
        }

        // 5. On vide le panier
        session()->forget('cart');

        // 6. Succès
        return view('client.success', compact('commande'));
    }
}