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
        Schema::create('seance_emploies', function (Blueprint $table) {
            $table->id();
            $table->time('heur_debut');
            $table->time('heur_fin');
            $table->enum('jours', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi']);
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained()->onDelete('cascade');
            $table->foreignId('salle_id')->constrained()->onDelete('cascade');
            $table->foreignId('emploie_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seance_emploies');
    }
};
