<?php

namespace App\Filament\Admin\Resources\AuthorAnswerResource\Pages;

use App\Filament\Admin\Resources\AuthorAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthorAnswers extends ListRecords
{
    protected static string $resource = AuthorAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Створити відповідь'),
        ];
    }
}
