<?php

namespace Tests\Feature;

use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_seuls_les_produits_en_stock_sont_affiches(): void
    {
        $disponible = Produit::factory()->create(['nom' => 'Doliprane', 'stock' => 10]);
        $epuise = Produit::factory()->rupture()->create(['nom' => 'Aspirine']);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee($disponible->nom);
        $response->assertDontSee($epuise->nom);
    }

    public function test_la_recherche_est_insensible_a_la_casse(): void
    {
        Produit::factory()->create(['nom' => 'Amoxicilline 1g']);
        Produit::factory()->create(['nom' => 'Ibuprofène']);

        $response = $this->get('/?search=AMOXICILLINE');

        $response->assertOk();
        $response->assertSee('Amoxicilline 1g');
        $response->assertDontSee('Ibuprofène');
    }

    public function test_le_filtre_par_categorie_fonctionne(): void
    {
        Produit::factory()->create(['nom' => 'Tensiomètre', 'categorie' => 'Matériel Médical']);
        Produit::factory()->create(['nom' => 'Doliprane', 'categorie' => 'Médicaments']);

        $response = $this->get('/?categorie=Matériel Médical');

        $response->assertOk();
        $response->assertSee('Tensiomètre');
        $response->assertDontSee('Doliprane');
    }

    public function test_les_produits_sur_ordonnance_sont_signales(): void
    {
        Produit::factory()->surOrdonnance()->create(['nom' => 'Tramadol']);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Ordonnance');
    }

    public function test_le_catalogue_est_pagine_a_12_par_page(): void
    {
        Produit::factory()->count(13)->create();

        $premierePage = $this->get('/');
        $deuxiemePage = $this->get('/?page=2');

        $premierePage->assertOk();
        $this->assertCount(12, $premierePage->viewData('produits'));
        $this->assertCount(1, $deuxiemePage->viewData('produits'));
    }
}
