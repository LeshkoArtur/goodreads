<?php

namespace App\Filament\Admin\Resources\AuthorQuestionResource\Pages;

use App\Filament\Admin\Resources\AuthorQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthorQuestions extends ListRecords
{
    protected static string $resource = AuthorQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Поставити питання'),
        ];
    }
}
