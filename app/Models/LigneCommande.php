<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;

    protected $fillable = ['commande_id', 'produit_id', 'quantite', 'prix_unitaire'];

    // --- RELATION 1 : COMMANDE ---
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // --- RELATION 2 : PRODUIT (Celle qui bloquait) ---
    // Elle doit être AVANT la dernière accolade du bas
    public function produit()
    {
        return $this->belongsTo(Produit::class)->withTrashed();
    }
    
} // <--- TOUT LE CODE DOIT ETRE AU DESSUS DE CETTE ACCOLADE