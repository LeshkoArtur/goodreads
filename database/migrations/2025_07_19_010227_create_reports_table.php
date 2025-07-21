<?php

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->uuidMorphs('reportable');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'reportable_id', 'reportable_type']);
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->enumAlterColumn('report_type', 'report_type', ReportType::class);
            $table->enumAlterColumn('status', 'status', ReportStatus::class, ReportStatus::PENDING);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
        DB::unprepared('DROP TYPE role');
        DB::unprepared('DROP TYPE gender');
    }
};
