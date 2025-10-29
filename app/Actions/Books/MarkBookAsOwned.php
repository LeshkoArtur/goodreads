<?php

namespace App\Actions\Books;

class MarkBookAsOwned extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'Власні книги';
    }
}
