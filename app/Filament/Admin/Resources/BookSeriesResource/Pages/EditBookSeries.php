<?php

namespace App\Filament\Admin\Resources\BookSeriesResource\Pages;

use App\Actions\BookSeries\UpdateBookSeries;
use App\Data\BookSeries\BookSeriesUpdateData;
use App\Filament\Admin\Resources\BookSeriesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBookSeries extends EditRecord
{
    protected static string $resource = BookSeriesResource::class;

    protected ?string $heading = 'Редагувати серію книг';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Переглянути'),
            Actions\DeleteAction::make()
                ->label('Видалити'),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = BookSeriesUpdateData::fromArray($data);

        return app(UpdateBookSeries::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Серію оновлено';
    }
}
