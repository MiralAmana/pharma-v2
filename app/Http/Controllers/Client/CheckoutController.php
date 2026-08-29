<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function valider(Request $request)
    {
        $cart = session()->get('cart');
        if (! $cart) {
            return redirect()->back()->with('error', 'Panier vide.');
        }

        // On revérifie le stock et les prix en base : la session ne fait foi de rien,
        // un produit a pu être modifié ou épuisé depuis l'ajout au panier.
        $produits = Produit::whereIn('id', array_keys($cart))->get()->keyBy('id');

        foreach ($cart as $id => $details) {
            $produit = $produits->get($id);

            if (! $produit) {
                return redirect()->back()->with('error', 'Un produit de votre panier n\'existe plus. Merci de le retirer.');
            }

            if ($produit->stock < $details['quantity']) {
                return redirect()->back()->with('error', 'Stock insuffisant pour "'.$produit->nom.'" (il reste '.$produit->stock.' unité(s)). Merci d\'ajuster la quantité.');
            }
        }

        $needsPrescription = $produits->contains(fn (Produit $p) => $p->sur_ordonnance);

        $request->validate([
            'ordonnance' => [$needsPrescription ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        // 1. Gestion de l'image (Ordonnance)
        // Stockée sur le disque "local" (storage/app/private), non exposé publiquement,
        // avec un nom généré aléatoirement (le nom original n'est jamais utilisé tel quel).
        $path = null;
        if ($request->hasFile('ordonnance')) {
            $file = $request->file('ordonnance');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('ordonnances', $filename, 'local');
        }

        // 2. Calcul Total (à partir du prix actuel en base, pas du prix figé en session)
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $produits->get($id)->prix * $details['quantity'];
        }

        // 3. Création Commande
        $commande = Commande::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'statut' => 'en_attente',
            'reference' => 'CMD-'.strtoupper(Str::random(6)),
            'image_ordonnance' => $path, // <--- On sauvegarde le chemin ici
        ]);

        // 4. Lignes de commande
        foreach ($cart as $id => $details) {
            LigneCommande::create([
                'commande_id' => $commande->id,
                'produit_id' => $id,
                'quantite' => $details['quantity'],
                'prix_unitaire' => $produits->get($id)->prix,
            ]);
        }

        session()->forget('cart');

        return view('client.success', compact('commande'));
    }
}
