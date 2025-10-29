<?php

namespace App\Actions\Books;

class MarkBookAsFavorite extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'Улюблене';
    }
}
