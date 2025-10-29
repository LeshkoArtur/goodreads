<?php

namespace App\Actions\Books;

class MarkBookAsDNF extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'Не закінчено';
    }
}
