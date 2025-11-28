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
    Schema::table('produits', function (Blueprint $table) {
        // On ajoute la catégorie après le nom
        $table->string('categorie')->default('Médicaments')->after('nom');
    });
}

public function down()
{
    Schema::table('produits', function (Blueprint $table) {
        $table->dropColumn('categorie');
    });
}
};
