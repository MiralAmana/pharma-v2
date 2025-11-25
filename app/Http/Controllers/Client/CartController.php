<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. VOIR LE PANIER
    public function index()
    {
        return view('client.cart'); // On va créer cette page juste après
    }

    // 2. AJOUTER UN PRODUIT
    public function addToCart($id)
    {
        $produit = Produit::findOrFail($id);

        // On récupère le panier actuel (ou un tableau vide si vide)
        $cart = session()->get('cart', []);

        // Si le produit existe déjà, on ajoute +1 à la quantité
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Sinon, on crée la ligne avec quantité 1
            $cart[$id] = [
                "name" => $produit->nom,
                "quantity" => 1,
                "price" => $produit->prix,
                "image" => $produit->image
            ];
        }

        // On sauvegarde dans la session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    // 3. SUPPRIMER UN PRODUIT (Pour l'instant, on supprime toute la ligne)
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }
}