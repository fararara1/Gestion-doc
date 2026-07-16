<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            $table->date('date_debut')->nullable();

            $table->date('date_fin')->nullable();

            $table->enum('statut', [
                'En attente',
                'En cours',
                'Terminé'
            ])->default('En attente');

            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

        });
    }


    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            $table->dropForeign(['department_id']);

            $table->dropColumn([
                'date_debut',
                'date_fin',
                'statut',
                'department_id'
            ]);

        });
    }
};