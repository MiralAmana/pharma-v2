<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use Carbon\Carbon;

class ProduitSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. MÉDICAMENTS
        // ==========================================
        Produit::firstOrCreate(
            ['nom' => 'Amoxicilline 1g (Antibiotique)'],
            [
                'categorie' => 'Médicaments',
                'description' => 'Antibiotique à large spectre pour infections bactériennes.',
                'prix' => 2800,
                'stock' => 50,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => true, // SUR ORDONNANCE
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Ibuprofène 400mg (Boîte de 20)'],
            [
                'categorie' => 'Médicaments',
                'description' => 'Anti-inflammatoire pour douleurs musculaires et maux de tête.',
                'prix' => 1200,
                'stock' => 100,
                'date_peremption' => Carbon::now()->addYears(3),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Tramadol 50mg (Antidouleur Puissant)'],
            [
                'categorie' => 'Médicaments',
                'description' => 'Analgésique opioïde pour douleurs modérées à intenses.',
                'prix' => 3500,
                'stock' => 20,
                'date_peremption' => Carbon::now()->addYears(1),
                'sur_ordonnance' => true, // SUR ORDONNANCE
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Gaviscon Menthe (Sachets)'],
            [
                'categorie' => 'Médicaments',
                'description' => 'Suspension buvable pour brûlures d\'estomac et reflux.',
                'prix' => 4000,
                'stock' => 40,
                'date_peremption' => Carbon::now()->addMonths(1), // ⚠️ PÉRIMÉ BIENTÔT (1 mois)
                'sur_ordonnance' => false,
            ]
        );

        // ==========================================
        // 2. SANTÉ & BIEN-ÊTRE
        // ==========================================
        Produit::firstOrCreate(
            ['nom' => 'Berocca Énergie (Comprimés)'],
            [
                'categorie' => 'Santé & Bien-être',
                'description' => 'Cocktail de vitamines et minéraux pour la forme physique.',
                'prix' => 5500,
                'stock' => 30,
                'date_peremption' => Carbon::now()->addYears(1),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Azinc Forme et Vitalité'],
            [
                'categorie' => 'Santé & Bien-être',
                'description' => 'Complément alimentaire pour adultes surmenés.',
                'prix' => 4500,
                'stock' => 25,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Probiotiques Lactibiane'],
            [
                'categorie' => 'Santé & Bien-être',
                'description' => 'Améliore la flore intestinale et la digestion.',
                'prix' => 8000,
                'stock' => 15,
                'date_peremption' => Carbon::now()->addYears(1),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Oméga 3 Cardio'],
            [
                'categorie' => 'Santé & Bien-être',
                'description' => 'Huile de poisson riche en EPA et DHA pour le cœur.',
                'prix' => 6000,
                'stock' => 20,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => false,
            ]
        );

        // ==========================================
        // 3. HYGIÈNE & SOINS
        // ==========================================
        Produit::firstOrCreate(
            ['nom' => 'Bétadine Jaune (Dermique)'],
            [
                'categorie' => 'Hygiène & Soins',
                'description' => 'Antiseptique local pour désinfecter les plaies.',
                'prix' => 2000,
                'stock' => 60,
                'date_peremption' => Carbon::now()->addYears(3),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Brosse à dents électrique Oral-B'],
            [
                'categorie' => 'Hygiène & Soins',
                'description' => 'Brosse rechargeable pour un nettoyage en profondeur.',
                'prix' => 15000,
                'stock' => 10,
                'date_peremption' => Carbon::now()->addYears(10),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Solution Hydroalcoolique (500ml)'],
            [
                'categorie' => 'Hygiène & Soins',
                'description' => 'Désinfection des mains par friction.',
                'prix' => 3000,
                'stock' => 100,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Fil dentaire ciré'],
            [
                'categorie' => 'Hygiène & Soins',
                'description' => 'Essentiel pour l\'hygiène interdentaire.',
                'prix' => 1500,
                'stock' => 50,
                'date_peremption' => Carbon::now()->addYears(5),
                'sur_ordonnance' => false,
            ]
        );

        // ==========================================
        // 4. MATÉRIEL MÉDICAL
        // ==========================================
        Produit::firstOrCreate(
            ['nom' => 'Tensiomètre Omron M3'],
            [
                'categorie' => 'Matériel Médical',
                'description' => 'Tensiomètre bras avec détection d\'arythmie.',
                'prix' => 35000,
                'stock' => 5,
                'date_peremption' => Carbon::now()->addYears(10),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Oxymètre de pouls'],
            [
                'categorie' => 'Matériel Médical',
                'description' => 'Mesure la saturation en oxygène dans le sang (SpO2).',
                'prix' => 12000,
                'stock' => 8,
                'date_peremption' => Carbon::now()->addYears(5),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Lecteur Glycémie Accu-Chek'],
            [
                'categorie' => 'Matériel Médical',
                'description' => 'Kit complet pour diabétiques.',
                'prix' => 18000,
                'stock' => 10,
                'date_peremption' => Carbon::now()->addYears(5),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Bandelettes Test Diabète (x50)'],
            [
                'categorie' => 'Matériel Médical',
                'description' => 'Recharge pour lecteur de glycémie.',
                'prix' => 9500,
                'stock' => 20,
                'date_peremption' => Carbon::now()->addDays(15), // ⚠️ PÉRIMÉ BIENTÔT (15 jours)
                'sur_ordonnance' => false,
            ]
        );

        // ==========================================
        // 5. BÉBÉ & MAMAN
        // ==========================================
        Produit::firstOrCreate(
            ['nom' => 'Sérum Physiologique (40 dosettes)'],
            [
                'categorie' => 'Bébé & Maman',
                'description' => 'Pour le nettoyage des yeux et du nez des nourrissons.',
                'prix' => 2500,
                'stock' => 80,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Lait Gallia Croissance 3'],
            [
                'categorie' => 'Bébé & Maman',
                'description' => 'Lait en poudre pour bébés à partir de 12 mois.',
                'prix' => 7000,
                'stock' => 30,
                'date_peremption' => Carbon::now()->addMonths(8),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Tire-lait Électrique Avent'],
            [
                'categorie' => 'Bébé & Maman',
                'description' => 'Confortable et compact pour les mamans actives.',
                'prix' => 45000,
                'stock' => 3,
                'date_peremption' => Carbon::now()->addYears(10),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Crème Bepanthen Pommade'],
            [
                'categorie' => 'Bébé & Maman',
                'description' => 'Soin des fesses rouges du bébé et des mamelons.',
                'prix' => 3000,
                'stock' => 40,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => false,
            ]
        );

        // ==========================================
        // 6. COSMÉTIQUES
        // ==========================================
        Produit::firstOrCreate(
            ['nom' => 'Eau Thermale Avène (300ml)'],
            [
                'categorie' => 'Cosmétiques',
                'description' => 'Apaise et adoucit les peaux sensibles.',
                'prix' => 5000,
                'stock' => 25,
                'date_peremption' => Carbon::now()->addYears(3),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Sérum Vitamine C La Roche-Posay'],
            [
                'categorie' => 'Cosmétiques',
                'description' => 'Sérum éclat anti-rides pour le visage.',
                'prix' => 18000,
                'stock' => 10,
                'date_peremption' => Carbon::now()->addYears(1),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Crème Hydratante CeraVe'],
            [
                'categorie' => 'Cosmétiques',
                'description' => 'Hydratation 24h pour peaux sèches à très sèches.',
                'prix' => 8500,
                'stock' => 20,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => false,
            ]
        );

        Produit::firstOrCreate(
            ['nom' => 'Baume Lèvres Rêve de Miel'],
            [
                'categorie' => 'Cosmétiques',
                'description' => 'Nuxe, baume ultra-nourrissant.',
                'prix' => 4000,
                'stock' => 30,
                'date_peremption' => Carbon::now()->addYears(2),
                'sur_ordonnance' => false,
            ]
        );
    }
}
