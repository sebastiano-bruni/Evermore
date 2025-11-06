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
        Schema::create('trusted_contacts', function (Blueprint $table) {
            $table->id();

            // Collega l'invito al profilo commemorativo
            $table->foreignId('commemorative_profile_id')->constrained()->onDelete('cascade');

            // Email della persona invitata
            $table->string('email');

            // ID dell'utente che ha accettato (nullo finché non accetta)
            $table->foreignId('trusted_user_id')->nullable()->constrained('users')->onDelete('set null');

            // Stato dell'invito
            $table->string('status')->default('pending'); // pending, accepted

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trusted_contacts');
    }
};
