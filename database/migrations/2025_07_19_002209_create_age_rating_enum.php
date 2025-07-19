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
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'age_rating') THEN
                CREATE TYPE age_rating AS ENUM ('0+', '6+', '12+', '16+', '18+');
            END IF;
        END$$;
    ");
    }

    public function down(): void {
        DB::statement("DROP TYPE IF EXISTS age_rating;");
    }
};
