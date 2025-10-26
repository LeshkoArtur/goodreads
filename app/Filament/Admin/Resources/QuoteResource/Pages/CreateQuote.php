<?php

namespace App\Filament\Admin\Resources\QuoteResource\Pages;

use App\DTOs\Quote\QuoteStoreDTO;
use App\Filament\Admin\Resources\QuoteResource;
use App\Models\Quote;
use App\Actions\Quotes\CreateQuote as CreateQuoteAction;
use Filament\Resources\Pages\CreateRecord;

class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;

    protected function handleRecordCreation(array $data): Quote
    {
        $dto = QuoteStoreDTO::fromArray($data);

        return CreateQuoteAction::run($dto);
    }
}
