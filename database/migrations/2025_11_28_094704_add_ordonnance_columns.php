<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // 1. Sur la table PRODUITS : un indicateur (Oui/Non)
    Schema::table('produits', function (Blueprint $table) {
        $table->boolean('sur_ordonnance')->default(false)->after('categorie');
    });

    // 2. Sur la table COMMANDES : le chemin du fichier image
    Schema::table('commandes', function (Blueprint $table) {
        $table->string('image_ordonnance')->nullable()->after('reference');
    });
}

public function down()
{
    Schema::table('produits', function (Blueprint $table) {
        $table->dropColumn('sur_ordonnance');
    });
    Schema::table('commandes', function (Blueprint $table) {
        $table->dropColumn('image_ordonnance');
    });
}
};
