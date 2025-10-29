<?php

namespace App\Filament\Admin\Resources\QuoteResource\Pages;

use App\Actions\Quotes\CreateQuote as CreateQuoteAction;
use App\Data\Quote\QuoteStoreData;
use App\Filament\Admin\Resources\QuoteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;

    protected ?string $heading = 'Створити цитату';

    protected function handleRecordCreation(array $data): Model
    {
        $dto = QuoteStoreData::fromArray($data);

        return app(CreateQuoteAction::class)->handle($dto);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Цитату створено';
    }
}
