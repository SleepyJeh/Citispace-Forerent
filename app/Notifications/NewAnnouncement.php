<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Property;

class NewAnnouncement extends Notification implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new notification instance.
     */
    public function __construct(public Announcement $announcement)
    {

    }

    /**
     * Notification channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail message.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Property name or global scope
        $propertyName = $this->announcement->property_id
            ? Property::find($this->announcement->property_id)?->building_name
            : 'All Properties';

        $role = strtolower($this->announcement->recipient_role ?? 'all');

        // Professional tone for each recipient role
        $intro = match ($role) {
            'manager' => "Dear Manager,\n\nWe appreciate your continued leadership and coordination across our community.",
            'tenant'  => "Dear Resident,\n\nWe hope you are enjoying a comfortable living experience. Please take note of the following update from management:",
            default   => "Dear Valued Member,\n\nPlease review the latest update from our property management team below:",
        };

        return (new MailMessage)
            ->subject("📢 {$this->announcement->title}")
            ->markdown('mail.new-announcement', [
                'propertyName'   => $propertyName,
                'title'          => $this->announcement->title,
                'description'    => $this->announcement->description,
                'recipientRole'  => ucfirst($role),
                'intro'          => $intro,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'announcement_id' => $this->announcement->id,
            'title' => $this->announcement->title,
        ];
    }
}
