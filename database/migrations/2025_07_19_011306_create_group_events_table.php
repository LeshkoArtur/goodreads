<?php

use App\Enums\EventStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->timestamp('event_date')->nullable();
            $table->string('location', 255)->nullable();
            $table->timestamps();
        });

        Schema::table('group_events', function (Blueprint $table) {
            $table->enumAlterColumn('group_status', 'group_status', EventStatus::class, EventStatus::UPCOMING);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_events');
        DB::unprepared('DROP TYPE group_events');
    }
};
