<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            "
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_constraint
        WHERE conname = 'check_notifications_type'
    ) THEN
        ALTER TABLE notifications
        ADD CONSTRAINT check_notifications_type
        CHECK (type IN ('friend_activity', 'group_post', 'new_book', 'recommendation'));
    END IF;
END
$$;
"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_check_constraint_to_notifications');
    }
};
