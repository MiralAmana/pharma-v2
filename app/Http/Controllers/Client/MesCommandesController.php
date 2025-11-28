<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class MesCommandesController extends Controller
{
    public function index()
    {
        // On récupère SEULEMENT les commandes de l'utilisateur connecté
        $commandes = Commande::where('user_id', Auth::id())
                             ->orderBy('created_at', 'desc') // Les plus récentes en haut
                             ->get();

        return view('client.commandes.index', compact('commandes'));
    }
}