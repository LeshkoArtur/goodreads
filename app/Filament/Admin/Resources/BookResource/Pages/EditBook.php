<?php

namespace App\Filament\Admin\Resources\BookResource\Pages;

use App\Actions\Books\UpdateBook;
use App\DTOs\Book\BookUpdateDTO;
use App\Filament\Admin\Resources\BookResource;
use App\Models\Book;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Book|Model $record, array $data): Book
    {
        $dto = BookUpdateDTO::fromArray($data);

        return UpdateBook::run($record, $dto);
    }
}
