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
            $table->string("etat_validation");
            $table->foreignId("seance_emploie_id")->constrained("seance_emploies")->onDelete('cascade');
            $table->foreignId("module_id")->constrained("modules")->onDelete('cascade');
            $table->foreignId("formateur_id")->nullable()->constrained("formateurs")->onDelete('set null');
            $table->foreignId("responsable_id")->nullable()->constrained("responsables")->onDelete('set null');
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
