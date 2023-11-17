<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_url' => $this->faker->imageUrl(640, 480, 'animals', true),
            'title' => $this->faker->realTextBetween(20, 128),
            'desc' => $this->faker->realTextBetween(200, 1024),
            'date_of_writing' => $this->faker->dateTimeThisCentury()
        ];
    }
}
