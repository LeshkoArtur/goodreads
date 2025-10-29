<?php

use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique()->after('email');
            $table->string('profile_picture', 2048)->nullable()->after('password');
            $table->text('bio')->nullable()->after('profile_picture');
            $table->boolean('is_public')->default(true)->after('bio');
            $table->date('birthday')->nullable()->after('is_public');
            $table->string('location', 100)->nullable()->after('birthday');
            $table->timestamp('last_login')->nullable()->after('location');
            $table->jsonb('social_media_links')->nullable()->after('last_login');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enumAlterColumn('role', 'role', Role::class);
            $table->enumAlterColumn('gender', 'gender', Gender::class, nullable: true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'profile_picture',
                'bio',
                'is_public',
                'birthday',
                'location',
                'last_login',
                'social_media_links',
                'role',
                'gender',
            ]);
        });

        DB::unprepared('DROP TYPE role');
        DB::unprepared('DROP TYPE gender');
    }
};
