<?php

namespace Database\Seeders;

use App\Models\Shelf;
use Illuminate\Database\Seeder;

class DefaultShelvesSeeder extends Seeder
{
    public function run(): void
    {
        $shelves = [
            ['name' => 'Хочу прочитати', 'user_id' => null],
            ['name' => 'Читаю зараз', 'user_id' => null],
            ['name' => 'Прочитано', 'user_id' => null],
            ['name' => 'Не закінчено', 'user_id' => null],
            ['name' => 'На паузі', 'user_id' => null],
            ['name' => 'Улюблене', 'user_id' => null],
            ['name' => 'Перечитую', 'user_id' => null],
            ['name' => 'Власні книги', 'user_id' => null],
        ];

        foreach ($shelves as $shelf) {
            Shelf::firstOrCreate(
                ['name' => $shelf['name'], 'user_id' => null],
                $shelf
            );
        }
    }
}
