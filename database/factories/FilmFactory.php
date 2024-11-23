<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->catchPhrase,
            'published' => $this->faker->boolean,
            'poster' => $this->faker->text(128),
        ];
    }
}
