<?php

namespace App\Actions\Books;

class MarkBookAsReading extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'Читаю зараз';
    }

    protected function getAdditionalCreateData(): array
    {
        return ['start_date' => now()];
    }
}
