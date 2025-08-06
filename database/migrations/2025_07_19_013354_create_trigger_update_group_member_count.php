<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION update_group_member_count()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE groups
                SET member_count = (
                    SELECT COUNT(*)
                    FROM group_members
                    WHERE group_id = groups.id
                )
                WHERE id IN (
                    SELECT group_id
                    FROM group_members
                    WHERE group_id = groups.id
                );
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trigger_update_group_member_count
            AFTER INSERT OR DELETE ON group_members
            FOR EACH ROW
            EXECUTE FUNCTION update_group_member_count();
        ');
    }

    public function down()
    {
        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_update_group_member_count ON group_members;
            DROP FUNCTION IF EXISTS update_group_member_count();
        ');
    }
};
