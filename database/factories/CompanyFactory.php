<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'pib' => fake()->unique()->numerify('########'),
            'maticni_broj' => fake()->optional()->numerify('########'),
            'adresa' => fake()->address(),
            'kontakt_osoba' => fake()->optional()->name(),
            'telefon' => fake()->optional()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}

