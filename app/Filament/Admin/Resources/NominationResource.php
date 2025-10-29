<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NominationResource\Pages;
use App\Models\Nomination;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NominationResource extends Resource
{
    protected static ?string $model = Nomination::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Нагороди та номінації';

    protected static ?int $navigationSort = 33;

    public static function getModelLabel(): string
    {
        return 'Номінація';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Номінації';
    }

    public static function getNavigationLabel(): string
    {
        return 'Номінації';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Номінація')->description('Інформація про номінацію нагороди')->schema([
                Select::make('award_id')->label('Нагорода')->helperText('До якої нагороди відноситься')->relationship('award', 'name')->required()->searchable()->preload(),
                TextInput::make('name')->label('Назва номінації')->helperText('Наприклад: Найкраща книга року')->required()->maxLength(255),
                Textarea::make('description')->label('Опис')->helperText('Опис номінації')->rows(4)->maxLength(1000),
            ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Номінація')->searchable()->sortable()->weight('bold'),
                TextColumn::make('award.name')->label('Нагорода')->searchable()->sortable(),
                TextColumn::make('award.year')->label('Рік')->badge()->color('primary'),
            ])
            ->filters([SelectFilter::make('award')->label('Нагорода')->relationship('award', 'name')->searchable()->preload()->multiple()])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->defaultSort('created_at', 'desc')->striped();
    }

    public static function getRelations(): array
    {
        return [
            NominationResource\RelationManagers\EntriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNominations::route('/'),
            'create' => Pages\CreateNomination::route('/create'),
            'edit' => Pages\EditNomination::route('/{record}/edit'),
        ];
    }
}
