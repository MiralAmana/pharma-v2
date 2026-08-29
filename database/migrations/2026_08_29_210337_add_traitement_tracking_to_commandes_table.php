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
        Schema::table('commandes', function (Blueprint $table) {
            // Qui a validé/annulé la commande, et quand — pour la traçabilité admin.
            $table->foreignId('traite_par_id')->nullable()->after('statut')->constrained('users')->nullOnDelete();
            $table->timestamp('traite_le')->nullable()->after('traite_par_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('traite_par_id');
            $table->dropColumn('traite_le');
        });
    }
};
