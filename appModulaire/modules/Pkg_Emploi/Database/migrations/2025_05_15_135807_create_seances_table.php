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
             $table->id('seance_id');
            // $table->foreignId('seance_id')->constrained('seances', 'seance_id')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('modules', 'module_id');
            $table->foreignId('salle_id')->constrained('salles', 'salle_id');
            $table->foreignId('formateur_id')->constrained('formateurs', 'formateur_id');
            $table->date('seance_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('jours', ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']);
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
