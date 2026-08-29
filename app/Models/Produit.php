<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
