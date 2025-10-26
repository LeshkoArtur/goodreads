<?php

namespace App\Filament\Admin\Resources\ShelfResource\Pages;

use App\Actions\Shelves\UpdateShelf;
use App\DTOs\Shelf\ShelfUpdateDTO;
use App\Filament\Admin\Resources\ShelfResource;
use App\Models\Shelf;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditShelf extends EditRecord
{
    protected static string $resource = ShelfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Shelf|Model $record, array $data): Shelf
    {
        $dto = ShelfUpdateDTO::fromArray($data);

        return UpdateShelf::run($record, $dto);
    }
}
