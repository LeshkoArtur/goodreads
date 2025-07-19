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
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'cover_type') THEN
                CREATE TYPE cover_type AS ENUM ('hardcover', 'paperback', 'other');
            END IF;
        END$$;
    ");
    }

    public function down(): void {
        DB::statement("DROP TYPE IF EXISTS cover_type;");
    }
};
