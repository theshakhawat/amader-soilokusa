<?php

namespace App\Notifications;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewVolunteerRegisteredNotification extends Notification
{
    use Queueable;

    public Volunteer $volunteer;

    /**
     * Create a new notification instance.
     */
    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'volunteer_registration',
            'title'       => 'নতুন স্বেচ্ছাসেবী আবেদন',
            'name'        => $this->volunteer->name,
            'message'     => "নতুন স্বেচ্ছাসেবী হিসেবে '{$this->volunteer->name}' নিবন্ধন আবেদন করেছেন।",
            'url'         => route('admin.volunteers.show', $this->volunteer->id),
            'id_number'   => $this->volunteer->card_id_number,
            'source_id'   => $this->volunteer->id,
            'photo'       => $this->volunteer->photo_url,
            'icon'        => 'ri-user-heart-line',
            'badge_color' => 'emerald',
            'created_at'  => now()->toIso8601String(),
        ];
    }
}
