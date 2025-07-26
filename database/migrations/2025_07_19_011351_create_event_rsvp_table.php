<?php

use App\Enums\EventResponse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_rsvp', function (Blueprint $table) {
            $table->foreignUuid('event_id')->constrained('group_events')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['event_id', 'user_id']);
        });

        Schema::table('event_rsvp', function (Blueprint $table) {
            $table->enumAlterColumn('event_response', 'event_response', EventResponse::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_rsvp');
        DB::unprepared('DROP TYPE event_response');
    }
};
