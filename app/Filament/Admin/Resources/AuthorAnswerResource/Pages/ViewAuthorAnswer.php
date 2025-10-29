<?php

namespace App\Filament\Admin\Resources\AuthorAnswerResource\Pages;

use App\Filament\Admin\Resources\AuthorAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAuthorAnswer extends ViewRecord
{
    protected static string $resource = AuthorAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
