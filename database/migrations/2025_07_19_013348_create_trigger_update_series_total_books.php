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
            CREATE OR REPLACE FUNCTION update_series_total_books()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE book_series
                SET total_books = (
                    SELECT COUNT(*)
                    FROM books
                    WHERE series_id = book_series.id
                )
                WHERE id IN (
                    SELECT series_id
                    FROM books
                    WHERE series_id = book_series.id
                );
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trigger_update_series_total_books
            AFTER INSERT OR DELETE ON books
            FOR EACH ROW
            EXECUTE FUNCTION update_series_total_books();
        ');
    }

    public function down()
    {
        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_update_series_total_books ON books;
            DROP FUNCTION IF EXISTS update_series_total_books();
        ');
    }
};
