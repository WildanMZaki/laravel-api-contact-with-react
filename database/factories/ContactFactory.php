<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('id_ID')->name(),
            'email' => fake('id_ID')->unique()->safeEmail(),
            'telephone_number' => 6280000000000 + fake()->numberBetween(1000000000, 2100000000)
        ];
    }
}
