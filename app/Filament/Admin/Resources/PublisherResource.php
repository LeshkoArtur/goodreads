<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PublisherResource\Pages;
use App\Models\Publisher;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PublisherResource extends Resource
{
    protected static ?string $model = Publisher::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Основні сутності';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'Видавництво';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Видавництва';
    }

    public static function getNavigationLabel(): string
    {
        return 'Видавництва';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'country', 'contact_email'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Країна' => $record->country ?: '—',
            'Рік заснування' => $record->founded_year ?: '—',
            'Книг' => $record->books_count ?? 0,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['books']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Базові дані про видавництво')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва видавництва')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Повна офіційна назва')
                            ->columnSpan(2),
                        FileUpload::make('logo')
                            ->label('Логотип')
                            ->image()
                            ->disk('public')
                            ->directory('publishers')
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->helperText('Квадратне зображення')
                            ->columnSpan(1),
                        Textarea::make('description')
                            ->label('Опис видавництва')
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText('Короткий опис діяльності (до 1000 символів)')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Контактна інформація')
                    ->description('Зв’язок з видавництвом')
                    ->schema([
                        TextInput::make('website')
                            ->label('Веб-сайт')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        TextInput::make('contact_email')
                            ->label('Email для зв’язку')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Телефон')
                            ->tel()
                            ->maxLength(50),
                    ])
                    ->columns(3),

                Section::make('Додаткова інформація')
                    ->description('Історичні дані')
                    ->schema([
                        TextInput::make('country')
                            ->label('Країна')
                            ->maxLength(100)
                            ->helperText('Країна розташування'),
                        TextInput::make('founded_year')
                            ->label('Рік заснування')
                            ->numeric()
                            ->minValue(1400)
                            ->maxValue(now()->year),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Логотип')
                    ->disk('public')
                    ->size(50)
                    ->circular(),
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('country')
                    ->label('Країна')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                TextColumn::make('founded_year')
                    ->label('Рік заснування')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('books_count')
                    ->label('Книг')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('contact_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
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
                SelectFilter::make('country')
                    ->label('Країна')
                    ->options(function () {
                        return Publisher::query()
                            ->whereNotNull('country')
                            ->distinct()
                            ->pluck('country', 'country')
                            ->toArray();
                    })
                    ->searchable(),
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
            ->defaultSort('name', 'asc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            PublisherResource\RelationManagers\BooksRelationManager::class,
            PublisherResource\RelationManagers\BookPublishersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublishers::route('/'),
            'create' => Pages\CreatePublisher::route('/create'),
            'view' => Pages\ViewPublisher::route('/{record}'),
            'edit' => Pages\EditPublisher::route('/{record}/edit'),
        ];
    }
}
