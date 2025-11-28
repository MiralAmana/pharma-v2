<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::where('stock', '>', 0);

        // Filtre par recherche
        if ($request->filled('search')) {
            $query->where('nom', 'ILIKE', "%{$request->search}%");
        }

        // Filtre par catégorie (NOUVEAU)
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $produits = $query->get();

        return view('welcome', compact('produits'));
    }
}