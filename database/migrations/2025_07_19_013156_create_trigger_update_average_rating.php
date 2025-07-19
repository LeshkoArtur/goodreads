<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION update_average_rating()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE books
                SET average_rating = COALESCE((
                    SELECT AVG(rating)
                    FROM ratings
                    WHERE book_id = NEW.book_id
                ), 0)
                WHERE id = NEW.book_id;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trigger_update_average_rating
            AFTER INSERT OR UPDATE OR DELETE ON ratings
            FOR EACH ROW
            EXECUTE FUNCTION update_average_rating();
        ');
    }

    public function down()
    {
        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_update_average_rating ON ratings;
            DROP FUNCTION IF EXISTS update_average_rating();
        ');
    }
};
