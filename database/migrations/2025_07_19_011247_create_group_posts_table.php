<?php

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        Schema::table('group_posts', function (Blueprint $table) {
            $table->enumAlterColumn('category', 'category', PostCategory::class, PostCategory::GENERAL->value);
            $table->enumAlterColumn('post_status', 'post_status', PostStatus::class, PostStatus::DRAFT->value);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_posts');
        DB::unprepared('DROP TYPE category');
        DB::unprepared('DROP TYPE post_status');
    }
};
