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
        $cart = session()->get('cart', []);

        // IDs des produits du panier qui sont sur ordonnance (calculé ici, pas dans la vue).
        $idsSurOrdonnance = Produit::whereIn('id', array_keys($cart))
            ->where('sur_ordonnance', true)
            ->pluck('id')
            ->all();

        $needsPrescription = ! empty($idsSurOrdonnance);

        return view('client.cart', compact('cart', 'needsPrescription', 'idsSurOrdonnance'));
    }

    // 2. AJOUTER UN PRODUIT
    public function addToCart(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $cart = session()->get('cart', []);
        $quantiteActuelle = $cart[$id]['quantity'] ?? 0;

        if ($quantiteActuelle + 1 > $produit->stock) {
            $message = 'Stock insuffisant : il ne reste que '.$produit->stock.' unité(s) de "'.$produit->nom.'".';

            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message, 'cartCount' => count($cart)]);
            }

            return redirect()->back()->with('error', $message);
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $produit->nom,
                'quantity' => 1,
                'price' => $produit->prix,
                'image' => $produit->image,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Produit ajouté au panier !', 'cartCount' => count($cart)]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    // 3. DIMINUER LA QUANTITÉ D'UNE LIGNE (retire la ligne si elle atteint 0)
    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']--;

            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Panier mis à jour.');
    }

    // 4. SUPPRIMER UN PRODUIT (toute la ligne)
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }
}
