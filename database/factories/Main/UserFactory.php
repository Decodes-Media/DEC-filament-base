<?php

namespace Database\Factories\Main;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Main\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => strtolower(Str::ulid()),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->e164PhoneNumber(),
            'password' => '$2y$12$Cef0WjmEsvISnX5IjbwUlO3YO4kOD7chiR1CCvsB2useoGV7H7xjm', // password
            'password_updated_at' => null,
            'remember_token' => Str::random(10),
            'is_active' => true,
            'note' => fake()->paragraph(),
        ];
    }
}
