<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total', 'statut', 'reference','image_ordonnance'];

// Une commande appartient à un client
public function user()
{
    return $this->belongsTo(User::class);
}
public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
