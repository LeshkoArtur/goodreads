<?php

use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_members', function (Blueprint $table) {
            $table->foreignUuid('group_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('joined_at')->useCurrent();
            $table->primary(['group_id', 'user_id']);
        });

        Schema::table('group_members', function (Blueprint $table) {
            $table->enumAlterColumn('member_role', 'member_role', MemberRole::class);
            $table->enumAlterColumn('member_status', 'member_status', MemberStatus::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_member');
        DB::unprepared('DROP TYPE member_role');
        DB::unprepared('DROP TYPE member_status');
    }
};
