<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport;

class MailSetting extends Model
{
    use HasFactory;

    protected $table = 'mail_settings';

    protected $fillable = [
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'status',
    ];

    protected $casts = [
        'mail_port' => 'integer',
        'status'    => 'boolean',
    ];

    /**
     * Dynamically override Laravel Mail configuration with database values.
     */
    public static function applyMailConfig(): void
    {
        try {
            $setting = static::first();
            if ($setting && $setting->status) {
                $encryption = ($setting->mail_encryption === 'none' || empty($setting->mail_encryption)) ? null : strtolower($setting->mail_encryption);

                config([
                    'mail.default' => $setting->mail_mailer ?: 'smtp',
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => $setting->mail_host,
                    'mail.mailers.smtp.port' => (int) ($setting->mail_port ?: 587),
                    'mail.mailers.smtp.encryption' => $encryption,
                    'mail.mailers.smtp.username' => $setting->mail_username,
                    'mail.mailers.smtp.password' => $setting->mail_password,
                    'mail.mailers.smtp.timeout' => 15,
                    'mail.from.address' => $setting->mail_from_address ?: config('mail.from.address'),
                    'mail.from.name' => $setting->mail_from_name ?: config('mail.from.name'),
                ]);

                // Reset Laravel MailManager cached mailer so it picks up the new config immediately
                if (app()->resolved('mail.manager')) {
                    app('mail.manager')->purge('smtp');
                }
            }
        } catch (\Throwable $e) {
            // Ignore during setup or early boot
        }
    }
}
