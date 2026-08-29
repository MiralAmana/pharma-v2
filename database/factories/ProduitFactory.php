<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->words(3, true),
            'categorie' => fake()->randomElement(Produit::CATEGORIES),
            'description' => fake()->sentence(),
            'prix' => fake()->numberBetween(500, 20000),
            'stock' => fake()->numberBetween(10, 100),
            'date_peremption' => now()->addYear(),
            'sur_ordonnance' => false,
        ];
    }

    public function surOrdonnance(): static
    {
        return $this->state(fn () => ['sur_ordonnance' => true]);
    }

    public function rupture(): static
    {
        return $this->state(fn () => ['stock' => 0]);
    }
}
