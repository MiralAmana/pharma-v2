<?php

namespace Tests\Feature\Admin;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProduitManagementTest extends TestCase
{
    use RefreshDatabase;

    private function gerant(): User
    {
        return User::factory()->create(['role' => 'gerant']);
    }

    private function client(): User
    {
        return User::factory()->create(['role' => 'client']);
    }

    public function test_un_client_ne_peut_pas_acceder_a_la_gestion_produits(): void
    {
        $response = $this->actingAs($this->client())->get(route('admin.produits.index'));

        $response->assertRedirect('/');
    }

    public function test_un_visiteur_non_connecte_est_redirige_vers_la_connexion(): void
    {
        $response = $this->get(route('admin.produits.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_un_gerant_peut_voir_la_liste_des_produits(): void
    {
        Produit::factory()->create(['nom' => 'Doliprane']);

        $response = $this->actingAs($this->gerant())->get(route('admin.produits.index'));

        $response->assertOk();
        $response->assertSee('Doliprane');
    }

    public function test_un_gerant_peut_creer_un_produit(): void
    {
        $response = $this->actingAs($this->gerant())->post(route('admin.produits.store'), [
            'nom' => 'Doliprane 1000mg',
            'categorie' => 'Médicaments',
            'prix' => 1500,
            'stock' => 50,
            'date_peremption' => now()->addYear()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.produits.index'));
        $this->assertDatabaseHas('produits', [
            'nom' => 'Doliprane 1000mg',
            'sur_ordonnance' => false,
        ]);
    }

    public function test_la_creation_echoue_avec_une_categorie_invalide(): void
    {
        $response = $this->actingAs($this->gerant())->post(route('admin.produits.store'), [
            'nom' => 'Produit Test',
            'categorie' => 'Categorie Inexistante',
            'prix' => 1500,
            'stock' => 50,
            'date_peremption' => now()->addYear()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('categorie');
        $this->assertDatabaseMissing('produits', ['nom' => 'Produit Test']);
    }

    public function test_un_gerant_peut_modifier_un_produit(): void
    {
        $produit = Produit::factory()->create(['prix' => 1000]);

        $response = $this->actingAs($this->gerant())->put(route('admin.produits.update', $produit->id), [
            'nom' => $produit->nom,
            'categorie' => $produit->categorie,
            'prix' => 2000,
            'stock' => $produit->stock,
            'date_peremption' => $produit->date_peremption->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.produits.index'));
        $this->assertDatabaseHas('produits', ['id' => $produit->id, 'prix' => 2000]);
    }

    public function test_un_gerant_peut_supprimer_un_produit_en_soft_delete(): void
    {
        $produit = Produit::factory()->create();

        $response = $this->actingAs($this->gerant())->delete(route('admin.produits.destroy', $produit->id));

        $response->assertRedirect();
        $this->assertSoftDeleted('produits', ['id' => $produit->id]);
    }
}
