<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantite');
            $table->date('date_peremption');
            $table->string('numero_lot')->nullable();
            $table->timestamps();

            $table->index(['produit_id', 'date_peremption']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
