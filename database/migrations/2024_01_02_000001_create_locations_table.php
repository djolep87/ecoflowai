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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('naziv');
            $table->string('adresa');
            $table->string('tip');
            $table->string('kontakt_osoba')->nullable();
            $table->string('telefon')->nullable();
            $table->string('status')->default('aktivna');
            $table->timestamps();

            $table->index('company_id');
            $table->index('tip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
