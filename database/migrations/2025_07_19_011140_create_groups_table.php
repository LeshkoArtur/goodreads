<?php

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 128);
            $table->text('description')->nullable();
            $table->foreignUuid('creator_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_public')->default(true);
            $table->string('cover_image', 248)->nullable();
            $table->text('rules')->nullable();
            $table->integer('member_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->enumAlterColumn('join_policy', 'join_policy', JoinPolicy::class, JoinPolicy::OPEN->value);
            $table->enumAlterColumn('post_policy', 'post_policy', PostPolicy::class, PostPolicy::ALL->value);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
        DB::unprepared('DROP TYPE join_policy');
        DB::unprepared('DROP TYPE post_policy');
    }
};
