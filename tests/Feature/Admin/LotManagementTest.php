<?php

namespace Tests\Feature\Admin;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LotManagementTest extends TestCase
{
    use RefreshDatabase;

    private function gerant(): User
    {
        return User::factory()->create(['role' => 'gerant']);
    }

    public function test_un_gerant_peut_receptionner_un_lot(): void
    {
        $produit = Produit::factory()->create(['stock' => 0]);

        $response = $this->actingAs($this->gerant())->post(route('admin.produits.lots.store', $produit->id), [
            'quantite' => 30,
            'date_peremption' => now()->addMonths(6)->format('Y-m-d'),
            'numero_lot' => 'LOT-001',
        ]);

        $response->assertRedirect();
        $this->assertSame(30, $produit->fresh()->stock);
        $this->assertDatabaseHas('lots', [
            'produit_id' => $produit->id,
            'quantite' => 30,
            'numero_lot' => 'LOT-001',
        ]);
    }

    public function test_receptionner_un_second_lot_additionne_le_stock(): void
    {
        $produit = Produit::factory()->create(['stock' => 20, 'date_peremption' => now()->addMonth()]);

        $this->actingAs($this->gerant())->post(route('admin.produits.lots.store', $produit->id), [
            'quantite' => 50,
            'date_peremption' => now()->addMonths(5)->format('Y-m-d'),
        ]);

        $this->assertSame(70, $produit->fresh()->stock);
        $this->assertSame(2, $produit->lots()->count());
    }

    public function test_la_date_de_peremption_du_produit_reflete_le_lot_le_plus_proche(): void
    {
        $produit = Produit::factory()->create(['stock' => 20, 'date_peremption' => now()->addYears(2)]);

        // Un nouveau lot périmant plus tôt que le lot existant doit devenir la référence.
        $dansUnMois = now()->addMonth()->startOfDay();
        $this->actingAs($this->gerant())->post(route('admin.produits.lots.store', $produit->id), [
            'quantite' => 10,
            'date_peremption' => $dansUnMois->format('Y-m-d'),
        ]);

        $this->assertTrue($produit->fresh()->date_peremption->isSameDay($dansUnMois));
    }

    public function test_un_client_ne_peut_pas_receptionner_de_lot(): void
    {
        $produit = Produit::factory()->create();
        $client = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($client)->post(route('admin.produits.lots.store', $produit->id), [
            'quantite' => 10,
            'date_peremption' => now()->addMonth()->format('Y-m-d'),
        ]);

        $response->assertRedirect('/');
    }

    public function test_un_gerant_peut_supprimer_un_lot(): void
    {
        $produit = Produit::factory()->create(['stock' => 10]);
        $lot = $produit->lots()->first();

        $response = $this->actingAs($this->gerant())->delete(route('admin.produits.lots.destroy', [$produit->id, $lot->id]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('lots', ['id' => $lot->id]);
        $this->assertSame(0, $produit->fresh()->stock);
    }
}
