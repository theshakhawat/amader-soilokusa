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
        Schema::table('members', function (Blueprint $table) {
            $table->string('occupation')->nullable()->after('blood_group');
            $table->text('permanent_address')->nullable()->after('address');
        });

        Schema::table('volunteers', function (Blueprint $table) {
            $table->string('occupation')->nullable()->after('blood_group');
            $table->text('permanent_address')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['occupation', 'permanent_address']);
        });

        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn(['occupation', 'permanent_address']);
        });
    }
};
