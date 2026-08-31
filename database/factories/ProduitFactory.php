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

    // Le stock réel provient des lots : on crée un lot correspondant au stock/date_peremption
    // demandés, pour que les tests existants (qui passent 'stock' directement) restent valides.
    public function configure(): static
    {
        return $this->afterCreating(function (Produit $produit) {
            if ($produit->stock > 0 && $produit->lots()->doesntExist()) {
                $produit->lots()->create([
                    'quantite' => $produit->stock,
                    'date_peremption' => $produit->date_peremption ?? now()->addYear(),
                ]);
            }
        });
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
