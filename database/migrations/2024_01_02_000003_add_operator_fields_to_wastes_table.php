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
        Schema::table('wastes', function (Blueprint $table) {
            $table->foreignId('operator_id')->nullable()->after('status')->constrained('users')->onDelete('set null');
            $table->dateTime('datum_preuzimanja')->nullable()->after('operator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            $table->dropForeign(['operator_id']);
            $table->dropColumn(['operator_id', 'datum_preuzimanja']);
        });
    }
};

