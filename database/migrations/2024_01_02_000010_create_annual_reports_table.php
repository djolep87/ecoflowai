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
        Schema::create('annual_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->integer('godina');
            $table->decimal('ukupno_kolicina', 10, 2);
            $table->integer('broj_vrsta_otpada');
            $table->text('napomena')->nullable();
            $table->timestamps();

            $table->index('company_id');
            $table->index('godina');
            $table->unique(['company_id', 'godina']); // Jedan izveštaj po firmi i godini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_reports');
    }
};

