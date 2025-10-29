<?php

namespace App\Filament\Admin\Resources\GroupPostResource\Pages;

use App\Filament\Admin\Resources\GroupPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupPosts extends ListRecords
{
    protected static string $resource = GroupPostResource::class;

    protected ?string $heading = 'Пости груп';

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Створити пост')];
    }
}
