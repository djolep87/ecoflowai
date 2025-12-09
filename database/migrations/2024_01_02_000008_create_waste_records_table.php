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
        Schema::create('waste_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('operator_id')->nullable()->constrained('operators')->onDelete('set null');
            $table->string('waste_type');
            $table->decimal('kolicina', 10, 2);
            $table->string('jedinica_mere'); // kg, t, l, m3
            $table->text('opis')->nullable();
            $table->date('datum_nastanka');
            $table->date('datum_predaje')->nullable();
            $table->string('status'); // nastao, spreman_za_predaju, predat
            $table->timestamps();

            $table->index('company_id');
            $table->index('operator_id');
            $table->index('status');
            $table->index('datum_nastanka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_records');
    }
};

