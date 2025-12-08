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
        Schema::create('kpo_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waste_id')->constrained('wastes')->onDelete('cascade');
            $table->date('datum');
            $table->decimal('kolicina', 10, 2);
            $table->string('nacin_postupanja');
            $table->text('opis')->nullable();
            $table->timestamps();

            $table->index('waste_id');
            $table->index('datum');
            $table->index('nacin_postupanja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpo_entries');
    }
};

