<?php

namespace App\Filament\Admin\Resources\AuthorQuestionResource\Pages;

use App\Filament\Admin\Resources\AuthorQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAuthorQuestion extends ViewRecord
{
    protected static string $resource = AuthorQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
