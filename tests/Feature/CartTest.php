<?php

namespace Tests\Feature;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_visiteur_non_connecte_ne_peut_pas_ajouter_au_panier(): void
    {
        $produit = Produit::factory()->create();

        $response = $this->post(route('cart.add', $produit->id));

        $response->assertRedirect(route('login'));
    }

    public function test_un_client_peut_ajouter_un_produit_au_panier(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);

        $response = $this->actingAs($user)->post(route('cart.add', $produit->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertSame(1, session('cart')[$produit->id]['quantity']);
    }

    public function test_ajouter_plusieurs_fois_incremente_la_quantite(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);

        $this->actingAs($user)->post(route('cart.add', $produit->id));
        $this->actingAs($user)->post(route('cart.add', $produit->id));

        $this->assertSame(2, session('cart')[$produit->id]['quantity']);
    }

    public function test_impossible_de_depasser_le_stock_disponible(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 2]);

        $this->actingAs($user)->post(route('cart.add', $produit->id));
        $this->actingAs($user)->post(route('cart.add', $produit->id));
        $response = $this->actingAs($user)->post(route('cart.add', $produit->id));

        $response->assertSessionHas('error');
        $this->assertSame(2, session('cart')[$produit->id]['quantity']);
    }

    public function test_ajouter_au_panier_en_ajax_retourne_du_json_sans_recharger(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);

        $response = $this->actingAs($user)->postJson(route('cart.add', $produit->id));

        $response->assertOk();
        $response->assertJson(['success' => true, 'cartCount' => 1]);
    }

    public function test_ajouter_au_panier_en_ajax_avec_stock_insuffisant(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 1]);
        $this->actingAs($user)->post(route('cart.add', $produit->id));

        $response = $this->actingAs($user)->postJson(route('cart.add', $produit->id));

        $response->assertOk();
        $response->assertJson(['success' => false, 'cartCount' => 1]);
    }

    public function test_diminuer_la_quantite_retire_la_ligne_a_zero(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);
        $this->actingAs($user)->post(route('cart.add', $produit->id));

        $this->actingAs($user)->post(route('cart.decrease', $produit->id));

        $this->assertArrayNotHasKey($produit->id, session('cart', []));
    }

    public function test_retirer_un_produit_supprime_toute_la_ligne(): void
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['stock' => 10]);
        $this->actingAs($user)->post(route('cart.add', $produit->id));
        $this->actingAs($user)->post(route('cart.add', $produit->id));

        $this->actingAs($user)->delete(route('cart.remove', $produit->id));

        $this->assertArrayNotHasKey($produit->id, session('cart', []));
    }
}
