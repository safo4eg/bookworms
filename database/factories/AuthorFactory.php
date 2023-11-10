<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'patronymic' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->dateTimeThisCentury(),
            'date_of_death' => $this->faker->dateTimeThisYear(),
            'origin' => $this->faker->city(),
            'desc' => $this->faker->realTextBetween(100, 1024)
        ];
    }
}
