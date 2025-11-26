<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        $lower = $this->faker->randomLetter(); 
        $upper = strtoupper($this->faker->randomLetter());
        $digit = $this->faker->randomDigit();

        $length = rand(5, 13);
        $random = $this->faker->regexify("[A-Za-z0-9]{$length}");

        $password = str_shuffle($lower . $upper . $digit . $random);

        return [
            'user' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'senha' => bcrypt($password),
            'admin' => $this->faker->boolean(10),
        ];
    }
}
