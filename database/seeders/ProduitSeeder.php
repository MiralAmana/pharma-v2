<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use Carbon\Carbon;

class ProduitSeeder extends Seeder
{
    public function run()
    {
        // 1. MÉDICAMENTS
        Produit::create([
            'nom' => 'Doliprane 1000mg (Boîte de 8)',
            'categorie' => 'Médicaments',
            'description' => 'Paracétamol pour soulager la douleur et la fièvre. Adulte et enfant +50kg.',
            'prix' => 1000,
            'stock' => 100,
            'date_peremption' => Carbon::now()->addYears(2),
        ]);
        Produit::create([
            'nom' => 'Spasfon Lyoc (Boîte de 10)',
            'categorie' => 'Médicaments',
            'description' => 'Traitement symptomatique des douleurs liées aux troubles fonctionnels du tube digestif.',
            'prix' => 2500,
            'stock' => 50,
            'date_peremption' => Carbon::now()->addYears(1),
        ]);

        // 2. SANTÉ & BIEN-ÊTRE
        Produit::create([
            'nom' => 'Juvamine Vitamine C',
            'categorie' => 'Santé & Bien-être',
            'description' => 'Comprimés à croquer pour réduire la fatigue et booster les défenses immunitaires.',
            'prix' => 3500,
            'stock' => 30,
            'date_peremption' => Carbon::now()->addYears(1),
        ]);
        Produit::create([
            'nom' => 'Magnésium Marin B6',
            'categorie' => 'Santé & Bien-être',
            'description' => 'Complément alimentaire pour lutter contre la nervosité et la fatigue musculaire.',
            'prix' => 4500,
            'stock' => 25,
            'date_peremption' => Carbon::now()->addYears(2),
        ]);

        // 3. HYGIÈNE & SOINS
        Produit::create([
            'nom' => 'Gel Nettoyant Saforelle',
            'categorie' => 'Hygiène & Soins',
            'description' => 'Soin lavant doux pour l\'hygiène intime et corporelle des peaux sensibles.',
            'prix' => 5000,
            'stock' => 40,
            'date_peremption' => Carbon::now()->addYears(3),
        ]);
        Produit::create([
            'nom' => 'Dentifrice Parodontax',
            'categorie' => 'Hygiène & Soins',
            'description' => 'Aide à arrêter et prévenir le saignement des gencives.',
            'prix' => 2800,
            'stock' => 60,
            'date_peremption' => Carbon::now()->addYears(2),
        ]);

        // 4. MATÉRIEL MÉDICAL
        Produit::create([
            'nom' => 'Thermomètre Digital Omron',
            'categorie' => 'Matériel Médical',
            'description' => 'Thermomètre électronique rapide et précis pour toute la famille.',
            'prix' => 4000,
            'stock' => 15,
            'date_peremption' => Carbon::now()->addYears(10), // Pas de vraie péremption
        ]);
        Produit::create([
            'nom' => 'Tensiomètre Bras Électronique',
            'categorie' => 'Matériel Médical',
            'description' => 'Mesure automatique de la tension artérielle et du pouls.',
            'prix' => 25000,
            'stock' => 5,
            'date_peremption' => Carbon::now()->addYears(10),
        ]);

        // 5. BÉBÉ & MAMAN
        Produit::create([
            'nom' => 'Lait Guigoz 1er Âge (800g)',
            'categorie' => 'Bébé & Maman',
            'description' => 'Lait en poudre pour nourrissons dès la naissance jusqu\'à 6 mois.',
            'prix' => 6500,
            'stock' => 50,
            'date_peremption' => Carbon::now()->addMonths(6),
        ]);
        Produit::create([
            'nom' => 'Couches Pampers T3 (Pack 50)',
            'categorie' => 'Bébé & Maman',
            'description' => 'Couches ultra-absorbantes pour bébés de 6 à 10 kg.',
            'prix' => 9000,
            'stock' => 20,
            'date_peremption' => Carbon::now()->addYears(5),
        ]);

        // 6. COSMÉTIQUES
        Produit::create([
            'nom' => 'La Roche-Posay Anthelios 50+',
            'categorie' => 'Cosmétiques',
            'description' => 'Crème solaire très haute protection pour peaux sensibles, sans parfum.',
            'prix' => 11000,
            'stock' => 12,
            'date_peremption' => Carbon::now()->addYears(1),
        ]);
        Produit::create([
            'nom' => 'Eau Micellaire Garnier (400ml)',
            'categorie' => 'Cosmétiques',
            'description' => 'Nettoie, démaquille et apaise en un seul geste sans rincer.',
            'prix' => 3200,
            'stock' => 30,
            'date_peremption' => Carbon::now()->addYears(2),
        ]);
        Produit::create([
    'nom' => 'Amoxicilline 1g (Antibiotique)',
    'categorie' => 'Médicaments',
    'description' => 'Antibiotique à large spectre. Sur ordonnance uniquement.',
    'prix' => 3000,
    'stock' => 50,
    'date_peremption' => Carbon::now()->addYears(2),
    'sur_ordonnance' => true, // <--- C'EST ICI
]);
    }
}