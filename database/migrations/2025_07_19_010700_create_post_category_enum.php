<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
    DO $$
    BEGIN
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'post_category_enum') THEN
            CREATE TYPE post_category_enum AS ENUM ('general', 'spoilers', 'recommendations', 'off_topic', 'other');
        END IF;
    END
    $$;
    ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS post_category_enum");
    }
};
