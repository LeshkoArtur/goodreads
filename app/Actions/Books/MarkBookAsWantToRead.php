<?php

namespace App\Actions\Books;

class MarkBookAsWantToRead extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'Хочу прочитати';
    }
}
