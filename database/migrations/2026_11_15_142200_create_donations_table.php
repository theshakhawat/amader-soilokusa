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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id', 64)->unique();
            $table->string('donor_name');
            $table->string('donor_phone', 32);
            $table->string('donor_email')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('BDT');
            $table->string('payment_method', 64)->nullable()->default('DgePay');
            $table->string('gateway_trx_id', 128)->nullable();
            $table->string('status', 32)->default('pending')->index(); // pending, success, failed, cancelled
            $table->json('payment_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->boolean('is_manual')->default(false)->index();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

