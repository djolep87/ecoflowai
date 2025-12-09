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
        Schema::create('waste_evidence_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('waste_type');
            $table->integer('godina');
            $table->decimal('ukupna_kolicina', 10, 2);
            $table->string('jedinica_mere');
            $table->text('opis')->nullable();
            $table->timestamps();

            $table->index('company_id');
            $table->index('godina');
            $table->index(['company_id', 'godina', 'waste_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_evidence_sheets');
    }
};

