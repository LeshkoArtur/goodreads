<?php

use App\Enums\EventResponse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_rsvps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_event_id')->constrained('group_events')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['group_event_id', 'user_id']);
        });

        Schema::table('event_rsvps', function (Blueprint $table) {
            $table->enumAlterColumn('response', 'event_response', EventResponse::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_rsvps');
        DB::unprepared('DROP TYPE event_response');
    }
};
