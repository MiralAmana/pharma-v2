<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\Produit::create([
        'nom' => 'Doliprane 1000mg',
        'description' => 'Paracétamol pour douleurs et fièvre.',
        'prix' => 1000,
        'stock' => 50,
        'date_peremption' => '2026-01-01',
    ]);

    \App\Models\Produit::create([
        'nom' => 'Efferalgan Vitamine C',
        'description' => 'Comprimés effervescents.',
        'prix' => 1500,
        'stock' => 30,
        'date_peremption' => '2025-12-12',
    ]);
    
    \App\Models\Produit::create([
        'nom' => 'Spasfon',
        'description' => 'Contre les douleurs spasmodiques.',
        'prix' => 2000,
        'stock' => 10,
        'date_peremption' => '2025-06-01',
    ]);
}
}
