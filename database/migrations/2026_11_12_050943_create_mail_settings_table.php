<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mail_mailer')->default('smtp'); // smtp, sendmail, log
            $table->string('mail_host')->nullable()->default('smtp.gmail.com');
            $table->integer('mail_port')->nullable()->default(587);
            $table->string('mail_username')->nullable();
            $table->text('mail_password')->nullable();
            $table->string('mail_encryption')->nullable()->default('tls'); // tls, ssl, null
            $table->string('mail_from_address')->nullable()->default('noreply@agamirshoilokuya.org');
            $table->string('mail_from_name')->nullable()->default('আগামীর শৈলকুপা');
            $table->boolean('status')->default(true); // active flag
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_settings');
    }
};
