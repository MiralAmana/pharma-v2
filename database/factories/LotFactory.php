<?php

namespace Database\Factories;

use App\Models\Lot;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lot>
 */
class LotFactory extends Factory
{
    protected $model = Lot::class;

    public function definition(): array
    {
        return [
            'produit_id' => Produit::factory(),
            'quantite' => fake()->numberBetween(10, 100),
            'date_peremption' => now()->addYear(),
            'numero_lot' => null,
        ];
    }
}
