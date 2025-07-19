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
        DB::statement("CREATE TYPE post_status_enum AS ENUM ('active', 'pending', 'deleted')");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS post_status_enum");
    }
};
