<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    private ?string $authorRole = null;

    public function definition(): array
    {
        $authorId = $this->getAuthorId();
        $author = User::find($authorId);

        return [
            'author_id'      => $authorId,
            'property_id'    => $this->getPropertyId(),
            'title'          => $this->faker->sentence(6),
            'description'    => $this->faker->paragraph(3),
            // Set recipient_role based on author role
            'recipient_role' => $this->determineRecipientRole($author->role),
            'created_at'     => $this->faker->dateTimeBetween('first day of November this year', 'last day of November this year'),
            'updated_at'     => $this->faker->dateTimeBetween('first day of November this year', 'last day of November this year')
        ];
    }

    public function authorRole(string $role): self
    {
        $factory = clone $this;
        $factory->authorRole = $role;
        return $factory;
    }

    private function getAuthorId(): int
    {
        $query = User::query();
        if ($this->authorRole) {
            $query->where('role', $this->authorRole);
        } else {
            $query->whereIn('role', ['landlord', 'manager']);
        }

        $author = $query->inRandomOrder()->first();

        if (!$author) {
            $author = User::factory()->create([
                'role' => $this->authorRole ?? 'landlord',
            ]);
        }

        return $author->user_id;
    }

    private function determineRecipientRole(string $authorRole): string
    {
        return match ($authorRole) {
            'landlord' => 'manager',
            default    => 'tenant', // fallback
        };
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
