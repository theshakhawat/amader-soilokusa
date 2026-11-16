<?php

namespace App\Jobs;

use App\Mail\MemberApprovedMail;
use App\Models\MailSetting;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendMemberApprovedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Member $member;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->member->email)) {
            Log::info("Member #{$this->member->id} has no email address. Skipping approval email.");
            return;
        }

        try {
            if (class_exists(MailSetting::class)) {
                MailSetting::applyMailConfig();
            }

            Mail::to($this->member->email)->send(new MemberApprovedMail($this->member));
            Log::info("Member approval email successfully sent to: {$this->member->email}");
        } catch (Throwable $e) {
            Log::error("Failed to send member approval email to {$this->member->email}: " . $e->getMessage());
        }
    }
}
