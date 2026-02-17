<?php

namespace Database\Factories;

use App\Models\Bed;
use Illuminate\Database\Eloquent\Factories\Factory;

class BedFactory extends Factory
{
    protected $model = Bed::class;

    public function definition(): array
    {
        return [
            'bed_number' => 'B1', // will be overridden
            'status'     => 'Vacant',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
