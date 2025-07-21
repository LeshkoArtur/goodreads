<?php

use App\Enums\InvitationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_invitations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('inviter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('invitee_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['group_id', 'invitee_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enumAlterColumn('invitation_status', 'invitation_status', InvitationStatus::class, InvitationStatus::PENDING);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_invitations');
    }
};
