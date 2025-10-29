<?php

namespace App\Filament\Admin\Resources\QuoteResource\Pages;

use App\Actions\Quotes\UpdateQuote;
use App\Data\Quote\QuoteUpdateData;
use App\Filament\Admin\Resources\QuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;

    protected ?string $heading = 'Редагувати цитату';

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
        $dto = QuoteUpdateData::fromArray($data);

        return app(UpdateQuote::class)->handle($record, $dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Цитату оновлено';
    }
}
