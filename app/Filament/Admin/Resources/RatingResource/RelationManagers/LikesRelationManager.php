<?php

namespace App\Filament\Admin\Resources\RatingResource\RelationManagers;

use App\Models\Like;
use App\Models\Rating;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class LikesRelationManager extends RelationManager
{
    protected static string $relationship = 'likes';

    protected static ?string $recordTitleAttribute = 'user.username';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Лайки до оцінки') . ' ' . $ownerRecord->rating . ' (' . $ownerRecord->book->title . ')';
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make(__('Лайк'))
                    ->schema([
                        Select::make('user_id')
                            ->label(__('Користувач'))
                            ->relationship('user', 'username')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label(__('Користувач'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): ?string => $record->user ? route('filament.admin.resources.users.view', $record->user_id) : null),
                TextColumn::make('created_at')
                    ->label(__('Дата лайку'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->label(__('Користувач'))
                    ->relationship('user', 'username')
                    ->searchable()
                    ->multiple()
                    ->indicator(__('Користувач')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Додати лайк')),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->label(__('Видалити')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('Видалити вибрані')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
