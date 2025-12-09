<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Operator;
use App\Models\User;
use App\Models\WasteContract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WasteContract>
 */
class WasteContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = now()->year;
        $company = Company::inRandomOrder()->first() ?? Company::factory()->create();
        $operator = Operator::inRandomOrder()->first() ?? Operator::factory()->create();
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'company_id' => $company->id,
            'operator_id' => $operator->id,
            'contract_number' => 'UG-' . $year . '-' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'date_start' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_end' => $this->faker->optional(0.7)->dateTimeBetween('now', '+1 year'),
            'waste_types' => $this->faker->randomElements(
                ['Papir', 'Plastika', 'Metal', 'Elektronski otpad', 'Staklo', 'Bio otpad'],
                $this->faker->numberBetween(1, 4)
            ),
            'notes' => $this->faker->optional(0.5)->sentence(),
            'pdf_path' => null,
            'created_by' => $user->id,
        ];
    }
}

