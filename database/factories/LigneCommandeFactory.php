<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LigneCommande>
 */
class LigneCommandeFactory extends Factory
{
    protected $model = LigneCommande::class;

    public function definition(): array
    {
        return [
            'commande_id' => Commande::factory(),
            'produit_id' => Produit::factory(),
            'quantite' => fake()->numberBetween(1, 3),
            'prix_unitaire' => fake()->numberBetween(500, 20000),
        ];
    }
}
