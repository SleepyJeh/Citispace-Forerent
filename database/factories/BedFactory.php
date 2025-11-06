<?php

namespace Database\Factories;

use App\Models\Bed;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class BedFactory extends Factory
{
    protected $model = Bed::class;

    // Track bed counters per unit and room
    protected static array $unitRoomCounters = [];

    public function definition(): array
    {
        $unit = $this->getUnit();

        $unitId = $unit->unit_id;

        // Determine number of rooms in the unit
        $roomCount = (int) ceil($unit->unit_cap / $unit->room_cap);

        // Initialize counters if not exists
        if (!isset(static::$unitRoomCounters[$unitId])) {
            static::$unitRoomCounters[$unitId] = [];
            for ($i = 0; $i < $roomCount; $i++) {
                static::$unitRoomCounters[$unitId][$i] = 1; // bed counter per room
            }
        }

        // Assign bed to a room
        // Find the first room with available bed slot
        $assignedRoomIndex = null;
        for ($i = 0; $i < $roomCount; $i++) {
            if (static::$unitRoomCounters[$unitId][$i] <= $unit->room_cap) {
                $assignedRoomIndex = $i;
                break;
            }
        }

        if ($assignedRoomIndex === null) {
            // Fallback if all rooms are full (shouldn't happen)
            $assignedRoomIndex = 0;
        }

        // Generate room letter: 0 => A, 1 => B, etc.
        $roomLetter = chr(65 + $assignedRoomIndex);
        $bedNumberInRoom = static::$unitRoomCounters[$unitId][$assignedRoomIndex];

        // Increment the counter
        static::$unitRoomCounters[$unitId][$assignedRoomIndex]++;

        $bedNumber = $roomLetter . $bedNumberInRoom;

        return [
            'unit_id'    => $unitId,
            'bed_number' => $bedNumber,
            'status'     => $this->faker->randomElement(['Vacant', 'Occupied']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function getUnit(): Unit
    {
        $unit = Unit::inRandomOrder()->first();

        if (!$unit) {
            $unit = Unit::factory()->create();
        }

        return $unit;
    }
}
