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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seance_emploi_id')->constrained("seance_emploies")->onDelete('cascade');
            $table->date("date");
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->integer('duree'); // en minutes
            $table->enum('jours', ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']);
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
