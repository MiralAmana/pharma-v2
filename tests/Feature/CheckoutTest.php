<?php

namespace Tests\Feature;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function panierPour(Produit $produit, int $quantite = 1, ?float $prix = null): array
    {
        return [$produit->id => [
            'name' => $produit->nom,
            'quantity' => $quantite,
            'price' => $prix ?? $produit->prix,
            'image' => null,
        ]];
    }

    public function test_impossible_de_valider_un_panier_vide(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('checkout.valider'));

        $response->assertSessionHas('error');
        $this->assertSame(0, Commande::count());
    }

    public function test_une_commande_est_creee_avec_le_bon_total(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10, 'prix' => 5000]);

        $response = $this->actingAs($user)
            ->withSession(['cart' => $this->panierPour($produit, 2)])
            ->post(route('checkout.valider'));

        $response->assertOk();
        $this->assertDatabaseHas('commandes', [
            'user_id' => $user->id,
            'total' => 10000,
            'statut' => 'en_attente',
        ]);
    }

    public function test_le_total_est_recalcule_sur_le_prix_actuel_pas_celui_fige_en_session(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10, 'prix' => 5000]);

        // Le panier a été rempli avec un ancien prix (avant une modification par l'admin).
        $response = $this->actingAs($user)
            ->withSession(['cart' => $this->panierPour($produit, 2, prix: 1)])
            ->post(route('checkout.valider'));

        $response->assertOk();
        $this->assertDatabaseHas('commandes', ['total' => 10000]);
        $this->assertDatabaseHas('ligne_commandes', ['prix_unitaire' => 5000]);
    }

    public function test_stock_insuffisant_bloque_la_commande(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 1]);

        $response = $this->actingAs($user)
            ->withSession(['cart' => $this->panierPour($produit, 5)])
            ->post(route('checkout.valider'));

        $response->assertSessionHas('error');
        $this->assertSame(0, Commande::count());
    }

    public function test_ordonnance_obligatoire_pour_un_produit_sur_ordonnance(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->surOrdonnance()->create(['stock' => 10]);

        $response = $this->actingAs($user)
            ->withSession(['cart' => $this->panierPour($produit)])
            ->post(route('checkout.valider'));

        $response->assertSessionHasErrors('ordonnance');
        $this->assertSame(0, Commande::count());
    }

    public function test_commande_creee_avec_ordonnance_fournie(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $produit = Produit::factory()->surOrdonnance()->create(['stock' => 10]);

        $response = $this->actingAs($user)
            ->withSession(['cart' => $this->panierPour($produit)])
            ->post(route('checkout.valider'), [
                // ->create() plutôt que ->image() : évite une dépendance à l'extension GD.
                'ordonnance' => UploadedFile::fake()->create('ordonnance.pdf', 100, 'application/pdf'),
            ]);

        $response->assertOk();
        $commande = Commande::first();
        $this->assertNotNull($commande->image_ordonnance);
        Storage::disk('local')->assertExists($commande->image_ordonnance);
    }

    public function test_le_panier_est_vide_apres_validation(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);

        $this->actingAs($user)
            ->withSession(['cart' => $this->panierPour($produit)])
            ->post(route('checkout.valider'));

        $this->assertArrayNotHasKey('cart', session()->all());
    }
}
