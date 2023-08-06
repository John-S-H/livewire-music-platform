<?php

namespace Database\Factories;

use App\Models\Post;
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
        $provinces = [
            'Groningen', 'Friesland', 'Drenthe', 'Overijssel', 'Gelderland',
            'Flevoland', 'Utrecht', 'Noord-Holland', 'Zuid-Holland',
            'Zeeland', 'Noord-Brabant', 'Limburg'
        ];

        $types = [
            'Bassist', 'Blokfluitist', 'Cellist', 'Componist', 'Rapper',
            'Drummer', 'Fluitist', 'Gitarist', 'Harpist', 'Hoboïst',
            'Hoornist', 'Klavecinist', 'Klarinettist', 'Organist',
            'Percussionist', 'Pianist', 'Saxofonist', 'Toetsenist',
            'Trombonist', 'Trompettist', 'Tubaïst', 'Violist', 'Zanger',
        ];

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->title(),
            'type' => $this->faker->randomElement($types),
            'description' => $this->faker->paragraph(),
            'province' => $this->faker->randomElement($provinces),
            'status' => $this->faker->boolean(),
        ];
    }
}