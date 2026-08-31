<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes; // <--- 1. AJOUTE CETTE LIGNE

class Produit extends Model
{
    use HasFactory, SoftDeletes; // <--- 2. AJOUTE "SoftDeletes" ICI

    // Source unique des catégories, utilisée par le catalogue et les formulaires admin.
    public const CATEGORIES = [
        'Médicaments',
        'Santé & Bien-être',
        'Hygiène & Soins',
        'Matériel Médical',
        'Bébé & Maman',
        'Cosmétiques',
    ];

    protected $fillable = [
        'nom',
        'categorie',
        'description',
        'prix',
        'stock',
        'image',
        'date_peremption',
        'sur_ordonnance',
    ];

    // Indique que ces colonnes sont des dates (pour le calcul de péremption)
    protected $casts = [
        'date_peremption' => 'date',
        'sur_ordonnance' => 'boolean',
    ];

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class);
    }

    // stock et date_peremption sont des colonnes dénormalisées, dérivées des lots
    // (stock = somme des quantités restantes, date_peremption = péremption du lot le plus proche).
    // À appeler après toute création/consommation/suppression de lot.
    public function syncStockDepuisLots(): void
    {
        $this->stock = $this->lots()->sum('quantite');
        $this->date_peremption = $this->lots()->where('quantite', '>', 0)->min('date_peremption');
        $this->saveQuietly();
    }
}
