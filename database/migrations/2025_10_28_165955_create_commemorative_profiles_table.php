<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx...create_commemorative_profiles_table.php

    public function up(): void
    {
        Schema::create('commemorative_profiles', function (Blueprint $table) {
            $table->id();

            // Collega il profilo all'utente che lo crea
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Campi per la ricerca OCR (RF12)
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable(); // Compilato post-mortem

            // Campi per i contenuti (RF5) [cite: 1563]
            $table->text('biography')->nullable();
            $table->text('passions')->nullable(); // Es. "Musica, Viaggi, Cucina"

            // Stato del profilo per il flusso di attivazione (RF11) [cite: 1578]
            $table->string('status')->default('draft'); // draft, pending_activation, active

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commemorative_profiles');
    }
};
