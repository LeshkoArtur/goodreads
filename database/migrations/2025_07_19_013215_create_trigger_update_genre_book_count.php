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
            CREATE OR REPLACE FUNCTION update_genre_book_count()
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE genres
                SET book_count = (
                    SELECT COUNT(*)
                    FROM book_genres
                    WHERE genre_id = genres.id
                )
                WHERE id IN (
                    SELECT genre_id
                    FROM book_genres
                    WHERE genre_id = genres.id
                );
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trigger_update_genre_book_count
            AFTER INSERT OR DELETE ON book_genres
            FOR EACH ROW
            EXECUTE FUNCTION update_genre_book_count();
        ');
    }

    public function down()
    {
        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_update_genre_book_count ON book_genres;
            DROP FUNCTION IF EXISTS update_genre_book_count();
        ');
    }
};
