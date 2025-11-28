<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function valider(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->back()->with('error', 'Panier vide.');
        }

        // 1. Gestion de l'image (Ordonnance)
        $path = null;
        if ($request->hasFile('ordonnance')) {
            // On enregistre dans le dossier 'public/ordonnances'
            $file = $request->file('ordonnance');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('ordonnances'), $filename);
            $path = 'ordonnances/' . $filename;
        }

        // 2. Calcul Total
        $total = 0;
        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // 3. Création Commande
        $commande = Commande::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'statut' => 'en_attente',
            'reference' => 'CMD-' . strtoupper(Str::random(6)),
            'image_ordonnance' => $path, // <--- On sauvegarde le chemin ici
        ]);

        // 4. Lignes de commande
        foreach($cart as $id => $details) {
            LigneCommande::create([
                'commande_id' => $commande->id,
                'produit_id' => $id,
                'quantite' => $details['quantity'],
                'prix_unitaire' => $details['price']
            ]);
        }

        session()->forget('cart');

        return view('client.success', compact('commande'));
    }
}