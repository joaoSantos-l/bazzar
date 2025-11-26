<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => Usuario::inRandomOrder()->first()->id ?? Usuario::factory(),
            'productName' => $this->faker->words(3, true),
            'seller' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'image_path' => null,
        ];
    }
}
