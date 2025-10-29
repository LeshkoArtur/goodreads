<?php

namespace App\Actions\Books;

class MarkBookAsRead extends MarkBookBase
{
    protected function getShelfName(): string
    {
        return 'Прочитано';
    }

    protected function getAdditionalUpdateData(): array
    {
        return ['read_date' => now()];
    }

    protected function getAdditionalCreateData(): array
    {
        return ['read_date' => now()];
    }
}
