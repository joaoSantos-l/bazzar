<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'user' => 'Admin',
            'email' => 'admin@mail.com',
            'senha' => Hash::make('@SilkSong2'),
            'admin' => true,
        ]);

        Usuario::factory()->count(50)->create();
    }
}
