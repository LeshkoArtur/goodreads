<?php

namespace App\Filament\Admin\Resources\QuoteResource\Pages;

use App\Actions\Quotes\UpdateQuote;
use App\DTOs\Quote\QuoteUpdateDTO;
use App\Filament\Admin\Resources\QuoteResource;
use App\Models\Quote;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Quote|Model $record, array $data): Quote
    {
        $dto = QuoteUpdateDTO::fromArray($data);

        return UpdateQuote::run($record, $dto);
    }
}
