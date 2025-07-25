<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('view_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->uuidMorphs('viewable');
            $table->timestamps();
            $table->unique(['user_id', 'viewable_id', 'viewable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('view_histories');
    }
};
