<?php

namespace App\Actions\Books;

class MarkBookAsRereading extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'Перечитую';
    }

    protected function getAdditionalCreateData(): array
    {
        return ['start_date' => now()];
    }
}
