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
        Schema::table('committees', function (Blueprint $table) {
            if (!Schema::hasColumn('committees', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('committees', 'second_row_count')) {
                $table->integer('second_row_count')->default(2)->after('is_active');
            }
        });

        Schema::table('committee_members', function (Blueprint $table) {
            if (!Schema::hasColumn('committee_members', 'phone')) {
                $table->string('phone')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            if (Schema::hasColumn('committees', 'second_row_count')) {
                $table->dropColumn('second_row_count');
            }
            if (Schema::hasColumn('committees', 'slug')) {
                $table->dropColumn('slug');
            }
        });

        Schema::table('committee_members', function (Blueprint $table) {
            if (Schema::hasColumn('committee_members', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};

