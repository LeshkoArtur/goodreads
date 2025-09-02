<?php

namespace App\Filament\Admin\Resources\QuoteResource\Pages;

use App\Filament\Admin\Resources\QuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;
}
