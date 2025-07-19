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
        DB::statement("CREATE TYPE join_policy_enum AS ENUM ('open', 'request', 'invite_only')");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS join_policy_enum");
    }
};
