<?php

namespace Tests\Feature;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrdonnanceAccessTest extends TestCase
{
    use RefreshDatabase;

    private function commandeAvecOrdonnance(User $proprietaire): Commande
    {
        Storage::fake('local');
        Storage::disk('local')->put('ordonnances/test.jpg', 'contenu-fictif');

        return Commande::factory()->create([
            'user_id' => $proprietaire->id,
            'image_ordonnance' => 'ordonnances/test.jpg',
        ]);
    }

    public function test_le_proprietaire_peut_voir_son_ordonnance(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $commande = $this->commandeAvecOrdonnance($client);

        $response = $this->actingAs($client)->get(route('ordonnances.show', $commande->id));

        $response->assertOk();
    }

    public function test_un_autre_client_ne_peut_pas_voir_l_ordonnance(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $autreClient = User::factory()->create(['role' => 'client']);
        $commande = $this->commandeAvecOrdonnance($client);

        $response = $this->actingAs($autreClient)->get(route('ordonnances.show', $commande->id));

        $response->assertForbidden();
    }

    public function test_le_gerant_peut_voir_n_importe_quelle_ordonnance(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $gerant = User::factory()->create(['role' => 'gerant']);
        $commande = $this->commandeAvecOrdonnance($client);

        $response = $this->actingAs($gerant)->get(route('ordonnances.show', $commande->id));

        $response->assertOk();
    }

    public function test_un_visiteur_non_connecte_est_redirige_vers_la_connexion(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $commande = $this->commandeAvecOrdonnance($client);

        $response = $this->get(route('ordonnances.show', $commande->id));

        $response->assertRedirect(route('login'));
    }
}
