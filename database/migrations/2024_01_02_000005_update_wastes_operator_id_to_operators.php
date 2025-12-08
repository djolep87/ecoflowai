<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Prvo proverimo i uklonimo postojeći foreign key ako postoji
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'wastes' 
            AND COLUMN_NAME = 'operator_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($foreignKeys)) {
            foreach ($foreignKeys as $key) {
                Schema::table('wastes', function (Blueprint $table) use ($key) {
                    $table->dropForeign([$key->CONSTRAINT_NAME]);
                });
            }
        }

        // Postavimo sve postojeće operator_id na NULL jer su bili povezani sa users tabelom
        DB::table('wastes')->whereNotNull('operator_id')->update(['operator_id' => null]);

        // Dodajmo novi foreign key ka operators tabeli
        Schema::table('wastes', function (Blueprint $table) {
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            $table->dropForeign(['operator_id']);
        });

        Schema::table('wastes', function (Blueprint $table) {
            $table->foreignId('operator_id')->nullable()->change();
            $table->foreign('operator_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};

