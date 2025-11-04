<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'property_id'   => $this->getPropertyId(),
            'manager_id'    => $this->faker->boolean(70)
                                ? $this->getManagerId()
                                : null,
            'floor_number'  => $this->faker->numberBetween(1, 10),
            'occupants'     => $this->faker->randomElement(['Male', 'Female', 'Co-ed']),
            'bed_type'      => $this->faker->randomElement(['Single', 'Bunk', 'Twin']),
            'room_type'     => $this->faker->randomElement(['Standard', 'Deluxe', 'Suite']),
            'room_cap'      => $this->faker->numberBetween(1, 4),
            'unit_cap'      => $this->faker->numberBetween(2, 8),
            'price'         => $this->faker->randomFloat(2, 3000, 15000),
            'amenities'     => null,
        ];
    }

    private function getManagerId(): ?int
    {
        $manager = User::where('role', 'manager')->inRandomOrder()->first();

        // If no manager exists, create one
        if (!$manager) {
            $manager = User::factory()->create(['role' => 'manager']);
        }

        return $manager->user_id;
    }

    private function getPropertyId(): int
    {
        $property = Property::inRandomOrder()->first();

        // If no property exists, create one
        if (!$property) {
            $property = Property::factory()->create();
        }

        return $property->property_id;
    }
}
