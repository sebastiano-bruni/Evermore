<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx...create_media_table.php

    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // Collega il media al profilo commemorativo
            $table->foreignId('commemorative_profile_id')->constrained()->onDelete('cascade');

            // Tipo di media (video, foto, ecc.) [cite: 1563, 1570]
            $table->string('type')->default('photo'); // es. 'video_message', 'photo'

            // Percorso del file in storage
            $table->string('file_path');

            $table->string('title')->nullable(); // Titolo opzionale

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
