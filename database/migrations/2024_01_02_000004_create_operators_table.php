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
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('broj_dozvole');
            $table->string('kategorija_dozvole');
            $table->string('adresa');
            $table->string('kontakt_osoba')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('aktivan');
            $table->timestamps();

            $table->index('status');
            $table->index('broj_dozvole');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};

