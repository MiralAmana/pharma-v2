<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer la recherche si elle existe
        $search = $request->input('search');

        // Requête de base : on veut les produits en stock
        $query = Produit::where('stock', '>', 0);

        // Si une recherche est faite, on filtre
        if ($search) {
            $query->where('nom', 'ILIKE', "%{$search}%"); 
            // Note: ILIKE est spécifique à PostgreSQL pour ignorer majuscules/minuscules
        }

        $produits = $query->get();

        return view('welcome', compact('produits'));
    }
}