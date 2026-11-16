<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewDonationReceivedNotification extends Notification
{
    use Queueable;

    public Donation $donation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
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
        $formattedAmount = '৳' . number_format($this->donation->amount, 2);

        return [
            'type'        => 'donation_received',
            'title'       => 'নতুন অনুদান জমা হয়েছে',
            'name'        => $this->donation->donor_name,
            'amount'      => $this->donation->amount,
            'message'     => "{$this->donation->donor_name} কর্তৃক {$formattedAmount} অনুদান জমা হয়েছে।",
            'url'         => route('admin.donations.show', $this->donation->id),
            'id_number'   => 'TRX: ' . $this->donation->trx_id,
            'source_id'   => $this->donation->id,
            'method'      => $this->donation->payment_method ?? 'অনলাইন',
            'icon'        => 'ri-hand-coin-line',
            'badge_color' => 'emerald',
            'created_at'  => now()->toIso8601String(),
        ];
    }
}
