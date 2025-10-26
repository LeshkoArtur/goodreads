<?php

namespace App\Filament\Admin\Resources\BookResource\Pages;

use App\DTOs\Book\BookStoreDTO;
use App\Filament\Admin\Resources\BookResource;
use App\Models\Book;
use App\Actions\Books\CreateBook as CreateBookAction;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    protected function handleRecordCreation(array $data): Book
    {
        $dto = BookStoreDTO::fromArray($data);

        return CreateBookAction::run($dto);
    }
}
