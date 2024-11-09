<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->date(format: 'Y-m-d h:m:s');

        return [
            'path' => fake()->imageUrl(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
