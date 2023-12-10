<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'province_id' => random_int(1, 10),
            'musician_type_id' => random_int(1, 23),
            'status' => $this->faker->boolean(),
        ];
    }
}
