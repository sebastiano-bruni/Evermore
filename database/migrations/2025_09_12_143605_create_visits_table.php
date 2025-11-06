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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();

            // Chi ha fatto la visita
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Chi è stato visitato (usiamo questo nome per coerenza)
            $table->foreignId('commemorative_profile_id')->constrained()->onDelete('cascade');

            // Per la mappa (RF16)
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Questo crea 'created_at' e 'updated_at'
            // 'created_at' sarà la nostra 'visit_date'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
