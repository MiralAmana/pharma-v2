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
    Schema::table('users', function (Blueprint $table) {
        // On ajoute les colonnes après l'email pour que ce soit propre
        $table->string('telephone')->nullable()->after('email');
        $table->text('adresse')->nullable()->after('telephone');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['telephone', 'adresse']);
    });
}
};
