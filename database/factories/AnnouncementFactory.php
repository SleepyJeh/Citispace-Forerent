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
        $propertyId = $this->getPropertyId();

        // Generate title and description based on context
        [$title, $description] = $this->generateTitleAndDescription($propertyId);

        return [
            'author_id'      => $authorId,
            'property_id'    => $propertyId,
            'title'          => $title,
            'description'    => $description,
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
            'manager'  => 'tenant',
            default    => 'tenant',
        };
    }

    private function getPropertyId(): ?int
    {
        $property = Property::inRandomOrder()->first();

        if (!$property) {
            $property = Property::factory()->create();
        }

        return $property->property_id;
    }

    private function generateTitleAndDescription(?int $propertyId): array
    {
        $titles = [
            'Maintenance' => [
                'Scheduled Maintenance Notice',
                'Laundry Room Maintenance',
                'Pool Area Cleaning',
                'Electrical System Upgrade',
                'HVAC Inspection Notice'
            ],
            'Alerts' => [
                'Water Outage Alert',
                'Parking Lot Closure',
                'Security Upgrade Announcement',
                'Fire Drill Reminder',
                'Pest Control Schedule'
            ],
            'Community' => [
                'New Community Rules',
                'Tenant Meeting Reminder',
                'Recycling Program Update',
                'Community Event Announcement',
                'Welcome New Tenants'
            ]
        ];

        $category = $this->faker->randomElement(array_keys($titles));
        $title = $this->faker->randomElement($titles[$category]);

        $description = match ($title) {
            'Scheduled Maintenance Notice' => "Property #$propertyId: General maintenance will be conducted on all units on " . $this->faker->dateTimeBetween('now', '+2 weeks')->format('F j, Y') . ". Expect temporary service interruptions.",
            'Laundry Room Maintenance' => "Property #$propertyId: The laundry room will be unavailable from " . $this->faker->time('H:i') . " to " . $this->faker->time('H:i') . " on " . $this->faker->dateTimeBetween('now', '+10 days')->format('F j, Y') . " for equipment servicing.",
            'Pool Area Cleaning' => "Property #$propertyId: Pool maintenance is scheduled for " . $this->faker->dayOfWeek . ". Please refrain from using the pool area during this time.",
            'Electrical System Upgrade' => "Property #$propertyId: Electrical system upgrade on " . $this->faker->dateTimeBetween('now', '+3 weeks')->format('F j, Y') . ". Expect brief power outages.",
            'HVAC Inspection Notice' => "Property #$propertyId: Routine HVAC inspection scheduled on " . $this->faker->dateTimeBetween('now', '+1 month')->format('F j, Y') . ". Please ensure access to units.",
            'Water Outage Alert' => "Property #$propertyId: Temporary water outage affecting certain floors on " . $this->faker->dateTimeBetween('now', '+7 days')->format('F j, Y') . " from " . $this->faker->time('H:i') . " to " . $this->faker->time('H:i') . ".",
            'Parking Lot Closure' => "Property #$propertyId: Parking lot closed on " . $this->faker->dateTimeBetween('now', '+14 days')->format('F j, Y') . " for resurfacing.",
            'Security Upgrade Announcement' => "Property #$propertyId: Security upgrades on " . $this->faker->dateTimeBetween('now', '+2 weeks')->format('F j, Y') . ". Minor access delays expected.",
            'Fire Drill Reminder' => "Property #$propertyId: Fire drill scheduled for " . $this->faker->dayOfWeek . " at " . $this->faker->time('H:i') . ". Follow safety instructions.",
            'Pest Control Schedule' => "Property #$propertyId: Pest control treatment in common areas on " . $this->faker->dateTimeBetween('now', '+10 days')->format('F j, Y') . ". Keep areas accessible.",
            'New Community Rules' => "Property #$propertyId: New community rules effective immediately. All tenants must comply.",
            'Tenant Meeting Reminder' => "Property #$propertyId: Tenant meeting scheduled for " . $this->faker->dateTimeBetween('now', '+2 weeks')->format('F j, Y') . " at " . $this->faker->time('H:i') . ". Attendance recommended.",
            'Recycling Program Update' => "Property #$propertyId: Recycling program updates effective " . $this->faker->dateTimeBetween('now', '+5 days')->format('F j, Y') . ". Follow new guidelines.",
            'Community Event Announcement' => "Property #$propertyId: Community event on " . $this->faker->dateTimeBetween('now', '+1 month')->format('F j, Y') . " at the common hall. Fun activities planned!",
            'Welcome New Tenants' => "Property #$propertyId: Welcome to our new tenants joining this month. Make them feel at home!",
            default => $this->faker->paragraph(3)
        };

        return [$title, $description];
    }
}
