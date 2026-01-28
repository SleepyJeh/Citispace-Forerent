<?php

// database/factories/UserFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Use the new first_name and last_name columns
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),

            'email' => fake()->unique()->safeEmail(),

            // Randomly pick one of your allowed roles
            'role' => fake()->randomElement(['tenant', 'manager', 'landlord']),

            'contact' => fake()->phoneNumber(),
            'profile_img' => null, // Or use fake()->imageUrl()
            'password' => 'password', // Will be hashed by the User model

            'email_verified_at' => now(),
            'phone_verified_at' => null, // Or 'now()' if you want them pre-verified

            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
