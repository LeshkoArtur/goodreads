<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CollectionResource\Pages;
use App\Models\Collection;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return 'Колекція';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Колекції';
    }

    public static function getNavigationLabel(): string
    {
        return 'Колекції';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Користувач' => $record->user->username,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user')->withCount('books');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Інформація про колекцію книг')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Власник колекції')
                            ->helperText('Користувач, який створив колекцію'),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Назва колекції')
                            ->helperText('Назва для колекції книг'),
                        RichEditor::make('description')
                            ->label('Опис колекції')
                            ->helperText('Детальний опис колекції')
                            ->columnSpanFull(),
                        FileUpload::make('cover_image')
                            ->image()
                            ->disk('public')
                            ->directory('collections')
                            ->imageEditor()
                            ->label('Обкладинка колекції'),
                        Toggle::make('is_public')
                            ->required()
                            ->default(true)
                            ->label('Публічна')
                            ->helperText('Чи можуть інші бачити цю колекцію'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->disk('public')
                    ->label('Обкладинка')
                    ->size(50),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('books_count')
                    ->label('Книг в колекції')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Користувач'),
                TernaryFilter::make('is_public')
                    ->label('Публічна'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            CollectionResource\RelationManagers\BooksRelationManager::class,
            CollectionResource\RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'view' => Pages\ViewCollection::route('/{record}'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}
