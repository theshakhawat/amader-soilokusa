<?php

namespace App\Jobs;

use App\Mail\VolunteerApprovedMail;
use App\Models\MailSetting;
use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendVolunteerApprovedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Volunteer $volunteer;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->volunteer->email)) {
            Log::info("Volunteer #{$this->volunteer->id} has no email address. Skipping approval email.");
            return;
        }

        try {
            // Apply dynamic database mail settings if enabled
            if (class_exists(MailSetting::class)) {
                MailSetting::applyMailConfig();
            }

            Mail::to($this->volunteer->email)->send(new VolunteerApprovedMail($this->volunteer));
            Log::info("Volunteer approval email successfully sent to: {$this->volunteer->email}");
        } catch (Throwable $e) {
            Log::error("Failed to send volunteer approval email to {$this->volunteer->email}: " . $e->getMessage());
        }
    }
}
