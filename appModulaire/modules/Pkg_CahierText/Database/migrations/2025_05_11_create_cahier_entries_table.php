<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cahier_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->float('heures_prevues');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->text('contenu')->nullable();
            $table->text('objectifs')->nullable();
            $table->enum('status', ['planifie', 'realise', 'annule'])->default('planifie');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cahier_entries');
    }
};
