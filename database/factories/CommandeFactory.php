<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    protected $model = Commande::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => fake()->numberBetween(1000, 50000),
            'statut' => 'en_attente',
            'reference' => 'CMD-'.strtoupper(Str::random(6)),
            'image_ordonnance' => null,
        ];
    }

    public function validee(): static
    {
        return $this->state(fn () => ['statut' => 'validée']);
    }

    public function annulee(): static
    {
        return $this->state(fn () => ['statut' => 'annulée']);
    }
}
