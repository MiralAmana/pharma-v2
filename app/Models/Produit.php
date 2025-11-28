<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['nom', 'categorie','sur_ordonnance','description', 'prix', 'stock', 'date_peremption'];
}
