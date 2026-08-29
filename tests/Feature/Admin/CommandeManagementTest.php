<?php

namespace Tests\Feature\Admin;

use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandeManagementTest extends TestCase
{
    use RefreshDatabase;

    private function gerant(): User
    {
        return User::factory()->create(['role' => 'gerant']);
    }

    public function test_un_client_ne_peut_pas_acceder_a_la_liste_des_commandes_admin(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($client)->get(route('admin.commandes'));

        $response->assertRedirect('/');
    }

    public function test_valider_une_commande_deduit_le_stock(): void
    {
        $produit = Produit::factory()->create(['stock' => 10]);
        $commande = Commande::factory()->create(['statut' => 'en_attente']);
        LigneCommande::factory()->create([
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 3,
        ]);

        $response = $this->actingAs($this->gerant())->post(route('admin.valider', $commande->id));

        $response->assertRedirect();
        $this->assertSame('validée', $commande->fresh()->statut);
        $this->assertSame(7, $produit->fresh()->stock);
    }

    public function test_valider_deux_fois_ne_deduit_le_stock_qu_une_fois(): void
    {
        $produit = Produit::factory()->create(['stock' => 10]);
        $commande = Commande::factory()->create(['statut' => 'en_attente']);
        LigneCommande::factory()->create([
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 3,
        ]);

        $gerant = $this->gerant();
        $this->actingAs($gerant)->post(route('admin.valider', $commande->id));
        $response = $this->actingAs($gerant)->post(route('admin.valider', $commande->id));

        $response->assertSessionHas('error');
        $this->assertSame(7, $produit->fresh()->stock);
    }

    public function test_valider_ne_deduit_pas_en_dessous_de_zero(): void
    {
        $produit = Produit::factory()->create(['stock' => 2]);
        $commande = Commande::factory()->create(['statut' => 'en_attente']);
        LigneCommande::factory()->create([
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 5,
        ]);

        $this->actingAs($this->gerant())->post(route('admin.valider', $commande->id));

        // Le stock n'est pas suffisant : on ne décrémente pas (comportement existant, non aggravé).
        $this->assertSame(2, $produit->fresh()->stock);
    }

    public function test_annuler_une_commande_en_attente_ne_touche_pas_au_stock(): void
    {
        $produit = Produit::factory()->create(['stock' => 10]);
        $commande = Commande::factory()->create(['statut' => 'en_attente']);
        LigneCommande::factory()->create([
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 3,
        ]);

        $this->actingAs($this->gerant())->post(route('admin.annuler', $commande->id));

        $this->assertSame('annulée', $commande->fresh()->statut);
        $this->assertSame(10, $produit->fresh()->stock);
    }

    public function test_annuler_une_commande_validee_remet_le_stock(): void
    {
        $produit = Produit::factory()->create(['stock' => 7]);
        $commande = Commande::factory()->create(['statut' => 'validée']);
        LigneCommande::factory()->create([
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 3,
        ]);

        $this->actingAs($this->gerant())->post(route('admin.annuler', $commande->id));

        $this->assertSame('annulée', $commande->fresh()->statut);
        $this->assertSame(10, $produit->fresh()->stock);
    }
}
