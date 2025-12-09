<?php

namespace Database\Seeders;

use App\Models\WasteContract;
use Illuminate\Database\Seeder;

class WasteContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WasteContract::factory()->count(5)->create();
    }
}

