<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class MailSettingController extends Controller
{
    /**
     * Display the email configuration form.
     */
    public function index(): View
    {
        $setting = MailSetting::firstOrCreate([], [
            'mail_mailer'       => env('MAIL_MAILER', 'smtp'),
            'mail_host'         => env('MAIL_HOST', 'smtp.gmail.com'),
            'mail_port'         => env('MAIL_PORT', 587),
            'mail_username'     => env('MAIL_USERNAME', ''),
            'mail_password'     => env('MAIL_PASSWORD', ''),
            'mail_encryption'   => env('MAIL_ENCRYPTION', 'tls'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS', 'noreply@agamirshoilokuya.org'),
            'mail_from_name'    => env('MAIL_FROM_NAME', 'আগামীর শৈলকুপা'),
            'status'            => true,
        ]);

        return view('admin.settings.mail', compact('setting'));
    }

    /**
     * Update the email configuration data.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mail_mailer'       => ['required', 'string', 'in:smtp,sendmail,log'],
            'mail_host'         => ['nullable', 'string', 'max:255'],
            'mail_port'         => ['nullable', 'integer'],
            'mail_username'     => ['nullable', 'string', 'max:255'],
            'mail_password'     => ['nullable', 'string', 'max:255'],
            'mail_encryption'   => ['nullable', 'string', 'in:tls,ssl,none'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name'    => ['required', 'string', 'max:255'],
            'status'            => ['nullable', 'boolean'],
        ]);

        $setting = MailSetting::firstOrCreate([]);

        $data = [
            'mail_mailer'       => trim($validated['mail_mailer']),
            'mail_host'         => trim($validated['mail_host'] ?? ''),
            'mail_port'         => (int) ($validated['mail_port'] ?? 587),
            'mail_username'     => trim($validated['mail_username'] ?? ''),
            'mail_encryption'   => $validated['mail_encryption'] ?? 'tls',
            'mail_from_address' => trim($validated['mail_from_address']),
            'mail_from_name'    => trim($validated['mail_from_name']),
            'status'            => $request->has('status'),
        ];

        // If password is submitted (not null/empty), update it; otherwise keep existing
        if ($request->filled('mail_password')) {
            $data['mail_password'] = trim($request->mail_password);
        }

        $setting->update($data);

        // Apply immediately in current runtime and purge existing cached mailers
        MailSetting::applyMailConfig();

        return redirect()->back()->with('success', 'ইমেইল কনফিগারেশন সফলভাবে ডাটাবেজে সংরক্ষণ করা হয়েছে!');
    }

    /**
     * Send a test email to verify SMTP credentials.
     */
    public function sendTestMail(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => ['required', 'email'],
        ], [
            'test_email.required' => 'টেস্ট ইমেইল ঠিকানা প্রদান করুন।',
            'test_email.email'    => 'সঠিক ইমেইল ঠিকানা দিন।',
        ]);

        $setting = MailSetting::first();
        if (!$setting || empty($setting->mail_host)) {
            return redirect()->back()->with('error', 'কোনো মেইল কনফিগারেশন পাওয়া যায়নি। অনুগ্রহ করে আগে সেটিংস সংরক্ষণ করুন।');
        }

        try {
            // Apply config fresh
            MailSetting::applyMailConfig();

            $targetEmail = trim($request->test_email);
            $siteName = config('mail.from.name', 'আগামীর শৈলকুপা');

            // Attempt to send email
            Mail::raw("অভিনন্দন! আপনার '{$siteName}' ওয়েবসাইটের ইমেইল (SMTP) কনফিগারেশন ডাটাবেজ থেকে সফলভাবে কাজ করছে।\n\nসার্ভার: {$setting->mail_host}:{$setting->mail_port} ({$setting->mail_encryption})\nপ্রেরক: " . config('mail.from.address') . "\nতারিখ ও সময়: " . now()->format('d M, Y h:i A'), function ($message) use ($targetEmail, $siteName) {
                $message->to($targetEmail)
                        ->subject("ইমেইল টেস্ট সফল — {$siteName}");
            });

            return redirect()->back()->with('success', "টেস্ট ইমেইলটি সফলভাবে '{$targetEmail}' ঠিকানায় পাঠানো হয়েছে!");
        } catch (\Throwable $e) {
            $errMsg = $e->getMessage();
            $hint = '';

            if (str_contains($errMsg, '535') || str_contains($errMsg, 'Incorrect authentication data') || str_contains($errMsg, 'authentication failed')) {
                $hint = " | সমাধান নির্দেশনা: আপনার মেইল সার্ভার '{$setting->mail_host}'-এ ইউজারনেম '{$setting->mail_username}' অথবা দেওয়া পাসওয়ার্ডটি ভুল হয়েছে। আপনার cPanel / Webmail-এর সঠিক ইমেইল ও পাসওয়ার্ড প্রদান করুন (অথবা Gmail হলে ১৬ অক্ষরের App Password দিন)।";
            } elseif (str_contains($errMsg, 'Connection could not be established') || str_contains($errMsg, 'timed out')) {
                $hint = " | সমাধান নির্দেশনা: মেইল সার্ভার বা পোর্টে কানেক্ট করা যায়নি। পোর্ট (৪৬৫ বা ৫৮৭) এবং এনক্রিপশন (SSL বা TLS) পরিবর্তন করে দেখুন।";
            }

            return redirect()->back()->with('error', "ইমেইল পাঠাতে ব্যর্থ হয়েছে। " . $errMsg . $hint);
        }
    }
}
