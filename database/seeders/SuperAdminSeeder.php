<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Створюємо одного супер адміна
        User::factory()->admin()->create([
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
    }
}
