<?php

namespace App\Filament\Admin\Resources;

use App\Enums\NominationStatus;
use App\Filament\Admin\Resources\NominationEntryResource\Pages;
use App\Models\NominationEntry;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NominationEntryResource extends Resource
{
    protected static ?string $model = NominationEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Нагороди та номінації';

    protected static ?int $navigationSort = 34;

    public static function getModelLabel(): string
    {
        return 'Запис номінації';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Записи номінацій';
    }

    public static function getNavigationLabel(): string
    {
        return 'Записи номінацій';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['nomination', 'book', 'author']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Запис номінації')->description('Кандидат на номінацію')->schema([
                    Select::make('nomination_id')->relationship('nomination', 'name')->required()->searchable()->preload()->label('Номінація')->helperText('Номінація нагороди'),
                    Select::make('book_id')->relationship('book', 'title')->searchable()->preload()->label('Книга')->helperText('Книга-кандидат'),
                    Select::make('author_id')->relationship('author', 'name')->searchable()->preload()->label('Автор')->helperText('Автор-кандидат'),
                    Select::make('status')->options(NominationStatus::class)->required()->native(false)->label('Статус')->helperText('Статус номінації'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomination.name')
                    ->label('Номінація')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Автор')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('nomination')->relationship('nomination', 'name')->searchable()->preload()->multiple()->label('Номінація'),
                SelectFilter::make('book')->relationship('book', 'title')->searchable()->preload()->multiple()->label('Книга'),
                SelectFilter::make('author')->relationship('author', 'name')->searchable()->preload()->multiple()->label('Автор'),
                SelectFilter::make('status')->options(NominationStatus::class)->label('Статус'),
            ])
            ->actions([ViewAction::make(), EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc')->striped();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNominationEntries::route('/'),
            'create' => Pages\CreateNominationEntry::route('/create'),
            'view' => Pages\ViewNominationEntry::route('/{record}'),
            'edit' => Pages\EditNominationEntry::route('/{record}/edit'),
        ];
    }
}
