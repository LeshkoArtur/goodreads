<?php

use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->unique();
            $table->string('email', 255)->unique();
            $table->string('password_hash', 255);
            $table->string('profile_picture', 2048)->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_public')->default(true);
            $table->date('birthday')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('address', 248)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->jsonb('social_media_links')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enumAlterColumn('role', 'role', Role::class);
            $table->enumAlterColumn('gender', 'gender', Gender::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        DB::unprepared('DROP TYPE role');
        DB::unprepared('DROP TYPE gender');
    }
};
