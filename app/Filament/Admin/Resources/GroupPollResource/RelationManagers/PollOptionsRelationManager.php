<?php

namespace App\Filament\Admin\Resources\GroupPollResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PollOptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'pollOptions';

    protected static ?string $recordTitleAttribute = 'option_text';

    protected static ?string $title = 'Варіанти відповідей';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('option_text')
                    ->label('Варіант відповіді')
                    ->required()
                    ->rows(2)
                    ->maxLength(500),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('option_text')
            ->columns([
                Tables\Columns\TextColumn::make('option_text')
                    ->label('Варіант')
                    ->searchable()
                    ->limit(80)
                    ->wrap()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('votes_count')
                    ->label('Голосів')
                    ->counts('pollVotes')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('percentage')
                    ->label('Відсоток')
                    ->getStateUsing(function ($record) {
                        $totalVotes = $record->poll->pollVotes()->count();
                        if ($totalVotes === 0) {
                            return '0%';
                        }
                        $optionVotes = $record->pollVotes()->count();

                        return round(($optionVotes / $totalVotes) * 100, 1).'%';
                    })
                    ->badge()
                    ->color('info'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Додати варіант')
                    ->modalHeading('Додати варіант відповіді'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редагувати'),
                Tables\Actions\DeleteAction::make()->label('Видалити')->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Видалити обрані')->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Немає варіантів')
            ->emptyStateDescription('Додайте варіанти відповідей для опитування.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label('Додати варіант'),
            ]);
    }
}
