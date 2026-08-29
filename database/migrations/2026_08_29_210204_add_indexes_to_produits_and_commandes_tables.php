<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->index('categorie');
            $table->index('stock');
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->index('statut');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropIndex(['categorie']);
            $table->dropIndex(['stock']);
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->dropIndex(['statut']);
            $table->dropIndex(['user_id']);
        });
    }
};
