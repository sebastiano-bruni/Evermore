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
        Schema::table('commemorative_profiles', function (Blueprint $table) {
            // Aggiunge la colonna per il file, dopo 'status'
            $table->string('death_certificate_path')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commemorative_profiles', function (Blueprint $table) {
            //
        });
    }
};
