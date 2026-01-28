<?php

namespace Database\Factories;

use App\Models\Bed;
use App\Models\Property;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    // Keep track of unit counters per floor
    protected static array $floorCounters = [];

    public function definition(): array
    {
        $floor = $this->faker->numberBetween(1, 10);

        return [
            'property_id'   => $this->getPropertyId(),
            'manager_id'    => $this->faker->boolean(70) ? $this->getManagerId() : null,
            'floor_number'  => $floor,
            'unit_number'   => $this->generateUnitNumber($floor),
            'occupants'     => $this->faker->randomElement(['Male', 'Female', 'Co-ed']),
            'bed_type'      => $this->faker->randomElement(['Single', 'Bunk', 'Twin']),
            'room_type'     => $this->faker->randomElement(['Standard', 'Deluxe', 'Suite']),
            'room_cap'      => $this->faker->numberBetween(1, 4),
            'unit_cap'      => $this->faker->numberBetween(2, 8),
            'price'         => $this->faker->randomFloat(2, 3000, 15000),
            'amenities'     => null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }

    private function generateUnitNumber(int $floor): string
    {
        // Initialize counter for this floor if not set
        if (!isset(static::$floorCounters[$floor])) {
            static::$floorCounters[$floor] = 1;
        }

        // Format: R + floor number + 2-digit counter
        $unitNumber = sprintf('U%d%02d', $floor, static::$floorCounters[$floor]);

        // Increment the counter for next unit on this floor
        static::$floorCounters[$floor]++;

        return $unitNumber;
    }

    private function getManagerId(): int
    {
        $manager = User::where('role', 'manager')->inRandomOrder()->first();

        if (!$manager) {
            $manager = User::factory()->create(['role' => 'manager']);
        }

        return $manager->user_id;
    }

    private function getPropertyId(): int
    {
        $property = Property::inRandomOrder()->first();

        if (!$property) {
            $property = Property::factory()->create();
        }

        return $property->property_id;
    }

    public function configure()
    {
        return $this->afterCreating(function (Unit $unit) {
            Bed::factory()->count($unit->unit_cap)->create([
                'unit_id' => $unit->unit_id,
            ]);
        });
    }
}
