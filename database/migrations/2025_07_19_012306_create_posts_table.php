<?php

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('book_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('author_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title', 248);
            $table->string('slug', 248)->nullable()->unique();
            $table->text('content');
            $table->string('cover_image', 2048)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->enumAlterColumn('type', 'post_type', PostType::class, PostType::ARTICLE->value);
            $table->enumAlterColumn('status', 'post_status', PostStatus::class, PostStatus::DRAFT->value);
        });

        DB::statement("ALTER TABLE posts ADD CONSTRAINT unique_slug CHECK (type != 'article' OR slug IS NOT NULL)");
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
        DB::unprepared('DROP TYPE post_type');
        DB::unprepared('DROP TYPE post_status');
    }
};
