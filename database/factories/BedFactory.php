<?php

namespace Database\Factories;

use App\Models\Bed;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class BedFactory extends Factory
{
    protected $model = Bed::class;

    public function definition(): array
    {
        return [
            'unit_id' => $this->getUnitId(),
            'bed_number' => $this->faker->randomNumber(),
            'status' => $this->faker->boolean(70) ? 'Occupied' : 'Vacant',
        ];
    }

    public function getUnitId(): int
    {
        $unit = Unit::inRandomOrder()->first();

        if(!$unit){
            $unit = Unit::factory()->create();
        }

        return $unit->unit_id;
    }
}
