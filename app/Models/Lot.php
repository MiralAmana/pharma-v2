<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'quantite',
        'date_peremption',
        'numero_lot',
    ];

    protected $casts = [
        'date_peremption' => 'date',
    ];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
