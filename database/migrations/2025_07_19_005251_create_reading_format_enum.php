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
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'reading_format') THEN
                    CREATE TYPE reading_format AS ENUM ('physical', 'ebook', 'audiobook', 'other');
                END IF;
            END$$;
        ");
    }

    public function down()
    {
        DB::statement("DROP TYPE IF EXISTS reading_format");
    }
};
