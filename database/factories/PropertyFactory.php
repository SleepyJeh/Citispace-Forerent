<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'owner_id'          => $this->getLandlordId(),
            'building_name'     => $this->faker->company . ' Apartments',
            'address'           => $this->faker->address,
            'prop_description'  => $this->faker->optional()->paragraph(3),
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    private function getLandlordId(): ?int
    {
        $landlord = User::where('role', 'landlord')->inRandomOrder()->first();

        // If no landlord exists, optionally create one
        if (!$landlord) {
            $landlord = User::factory()->create(['role' => 'landlord']);
        }

        return $landlord->user_id;
    }
}
