<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total', 'statut', 'reference', 'image_ordonnance'];

    protected $casts = [
        'traite_le' => 'datetime',
    ];

    // Une commande appartient à un client
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }

    // Le gérant qui a validé/annulé la commande.
    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par_id');
    }
}
