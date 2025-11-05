<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'author_id'      => $this->getAuthorId(),
            'property_id'    => $this->getPropertyId(),
            'title'          => $this->faker->sentence(6),
            'description'    => $this->faker->paragraph(3),
            'recipient_role' => $this->faker->randomElement(['manager', 'tenant']),
            'created_at'     => $this->faker->dateTimeBetween('first day of January this year', 'last day of December this year'),
            'updated_at'     => $this->faker->dateTimeBetween('first day of January this year', 'last day of December this year')
        ];
    }

    private function getAuthorId(): int
    {
        $author = User::whereIn('role', ['landlord', 'manager'])
            ->inRandomOrder()
            ->first();

        if (!$author) {
            $author = User::factory()->create(['role' => 'landlord']);
        }

        return $author->user_id;
    }

    private function getPropertyId(): ?int
    {
        $property = Property::inRandomOrder()->first();

        if (!$property) {
            $property = Property::factory()->create();
        }

        // Occasionally return null to simulate global announcements
        return $this->faker->boolean(20) ? null : $property->property_id;
    }
}
