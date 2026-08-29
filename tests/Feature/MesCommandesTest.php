<?php

namespace Tests\Feature;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MesCommandesTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_client_ne_voit_que_ses_propres_commandes(): void
    {
        $client = User::factory()->create();
        $autreClient = User::factory()->create();

        $maCommande = Commande::factory()->create(['user_id' => $client->id, 'reference' => 'CMD-MOI']);
        Commande::factory()->create(['user_id' => $autreClient->id, 'reference' => 'CMD-AUTRE']);

        $response = $this->actingAs($client)->get(route('client.commandes.index'));

        $response->assertOk();
        $response->assertSee('CMD-MOI');
        $response->assertDontSee('CMD-AUTRE');
    }
}
