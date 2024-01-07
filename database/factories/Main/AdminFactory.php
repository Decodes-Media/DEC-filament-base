<?php

namespace Database\Factories\Main;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Main\Admin>
 */
class AdminFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => strtolower(Str::ulid()),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->e164PhoneNumber(),
            // 'password' => '$2y$12$LCzumewG/xxSmvWEomLR8OdvXHghG5ffNX2Vc0zqBarQGV2JnndMC', // password
            'password' => Hash::make('password'),
            'password_updated_at' => null,
            'remember_token' => Str::random(10),
            'is_active' => true,
            'note' => fake()->paragraph(),
        ];
    }
}
