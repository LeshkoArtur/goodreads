<?php

namespace App\Actions\Characters;

use App\Models\Book;
use App\Models\Character;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCharacterBook
{
    use AsAction;

    public function handle(Character $character): Book
    {
        return $character->book;
    }
}
