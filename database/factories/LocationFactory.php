<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipovi = ['magacin', 'prodavnica', 'pogon', 'kancelarija'];

        return [
            'company_id' => Company::factory(),
            'naziv' => fake()->words(3, true),
            'adresa' => fake()->address(),
            'tip' => fake()->randomElement($tipovi),
            'kontakt_osoba' => fake()->optional()->name(),
            'telefon' => fake()->optional()->phoneNumber(),
            'status' => 'aktivna',
        ];
    }
}

