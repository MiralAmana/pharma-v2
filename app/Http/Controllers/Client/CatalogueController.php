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

        // Filtre par recherche (insensible à la casse, portable entre SGBD)
        if ($request->filled('search')) {
            $query->whereRaw('LOWER(nom) LIKE ?', ['%'.mb_strtolower($request->search).'%']);
        }

        // Filtre par catégorie (NOUVEAU)
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $produits = $query->paginate(12)->withQueryString();

        return view('welcome', compact('produits'));
    }
}
