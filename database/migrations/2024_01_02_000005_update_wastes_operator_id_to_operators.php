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
        // Koristimo try-catch jer foreign key možda ne postoji
        try {
            Schema::table('wastes', function (Blueprint $table) {
                // dropForeign accepts column name as array
                $table->dropForeign(['operator_id']);
            });
        } catch (\Exception $e) {
            // Foreign key doesn't exist or has different name, try to find and drop it
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
                    try {
                        DB::statement("ALTER TABLE wastes DROP FOREIGN KEY `{$key->CONSTRAINT_NAME}`");
                    } catch (\Exception $e) {
                        // Continue if it fails
                    }
                }
            }
        }

        // Postavimo sve postojeće operator_id na NULL jer su bili povezani sa users tabelom
        DB::table('wastes')->whereNotNull('operator_id')->update(['operator_id' => null]);

        // Proverimo da li foreign key ka operators već postoji
        $existingForeignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'wastes' 
            AND COLUMN_NAME = 'operator_id' 
            AND REFERENCED_TABLE_NAME = 'operators'
        ");

        // Dodajmo novi foreign key ka operators tabeli samo ako ne postoji
        if (empty($existingForeignKeys)) {
            Schema::table('wastes', function (Blueprint $table) {
                $table->foreign('operator_id')->references('id')->on('operators')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            try {
                $table->dropForeign(['operator_id']);
            } catch (\Exception $e) {
                // Foreign key might not exist
            }
        });

        Schema::table('wastes', function (Blueprint $table) {
            $table->foreignId('operator_id')->nullable()->change();
            $table->foreign('operator_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};
