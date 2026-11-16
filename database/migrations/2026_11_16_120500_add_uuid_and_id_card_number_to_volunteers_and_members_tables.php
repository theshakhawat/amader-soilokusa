<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Volunteer;
use App\Models\Member;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
            $table->string('id_card_number', 50)->nullable()->after('slug');
            $table->string('signature')->nullable()->after('notes');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
            $table->string('id_card_number', 50)->nullable()->after('slug');
            $table->string('signature')->nullable()->after('notes');
        });

        // Populate existing volunteers with uuid and id_card_number
        $volunteers = \DB::table('volunteers')->get();
        foreach ($volunteers as $v) {
            $year = $v->created_at ? date('Y', strtotime($v->created_at)) : date('Y');
            \DB::table('volunteers')->where('id', $v->id)->update([
                'uuid' => (string) Str::uuid(),
                'id_card_number' => 'ASV-' . $year . '-' . str_pad((string)$v->id, 4, '0', STR_PAD_LEFT),
            ]);
        }

        // Populate existing members with uuid and id_card_number
        $members = \DB::table('members')->get();
        foreach ($members as $m) {
            $year = $m->created_at ? date('Y', strtotime($m->created_at)) : date('Y');
            \DB::table('members')->where('id', $m->id)->update([
                'uuid' => (string) Str::uuid(),
                'id_card_number' => 'ASM-' . $year . '-' . str_pad((string)$m->id, 4, '0', STR_PAD_LEFT),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'id_card_number', 'signature']);
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'id_card_number', 'signature']);
        });
    }
};
