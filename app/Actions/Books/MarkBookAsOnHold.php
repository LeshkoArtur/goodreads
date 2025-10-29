<?php

namespace App\Actions\Books;

class MarkBookAsOnHold extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'На паузі';
    }
}
