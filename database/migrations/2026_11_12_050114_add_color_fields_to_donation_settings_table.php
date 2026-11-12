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
        Schema::table('donation_settings', function (Blueprint $table) {
            $table->string('bg_color_start')->default('#d92638')->after('icon');
            $table->string('bg_color_end')->default('#7d0615')->after('bg_color_start');
            $table->string('text_color')->default('#ffffff')->after('bg_color_end');
            $table->string('button_bg_color')->default('#ffffff')->after('text_color');
            $table->string('button_text_color')->default('#111827')->after('button_bg_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donation_settings', function (Blueprint $table) {
            $table->dropColumn([
                'bg_color_start',
                'bg_color_end',
                'text_color',
                'button_bg_color',
                'button_text_color',
            ]);
        });
    }
};
