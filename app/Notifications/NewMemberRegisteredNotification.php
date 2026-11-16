<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMemberRegisteredNotification extends Notification
{
    use Queueable;

    public Member $member;

    /**
     * Create a new notification instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
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
            'type'        => 'member_registration',
            'title'       => 'নতুন সদস্য আবেদন',
            'name'        => $this->member->name,
            'message'     => "নতুন সদস্য হিসেবে '{$this->member->name}' নিবন্ধন আবেদন করেছেন।",
            'url'         => route('admin.members.show', $this->member->id),
            'id_number'   => $this->member->card_id_number,
            'source_id'   => $this->member->id,
            'photo'       => $this->member->photo_url,
            'icon'        => 'ri-vip-crown-line',
            'badge_color' => 'blue',
            'created_at'  => now()->toIso8601String(),
        ];
    }
}
