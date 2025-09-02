<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PublisherResource\Pages\CreatePublisher;
use App\Filament\Admin\Resources\PublisherResource\Pages\EditPublisher;
use App\Filament\Admin\Resources\PublisherResource\Pages\ListPublishers;
use App\Filament\Admin\Resources\PublisherResource\Pages\ViewPublisher;
use App\Filament\Admin\Resources\PublisherResource\RelationManagers\BooksRelationManager;
use App\Models\Publisher;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PublisherResource extends Resource
{
    protected static ?string $model = Publisher::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Видавці';

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __('Видавці');
    }

    public static function getModelLabel(): string
    {
        return __('Видавець');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Видавці');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make(__('Видавець'))
                    ->tabs([
                        Tabs\Tab::make(__('Основна інформація'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('Назва'))
                                    ->required()
                                    ->maxLength(100),

                                Textarea::make('description')
                                    ->label(__('Опис'))
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->columnSpanFull(),

                                TextInput::make('website')
                                    ->label(__('Вебсайт'))
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable(),

                                TextInput::make('country')
                                    ->label(__('Країна'))
                                    ->maxLength(100)
                                    ->nullable(),

                                TextInput::make('founded_year')
                                    ->label(__('Рік заснування'))
                                    ->numeric()
                                    ->minValue(1000)
                                    ->maxValue(date('Y'))
                                    ->nullable(),
                            ]),

                        Tabs\Tab::make(__('Контакти та медіа'))
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label(__('Логотип'))
                                    ->directory('logo')
                                    ->image()
                                    ->maxSize(2048)
                                    ->nullable(),

                                TextInput::make('contact_email')
                                    ->label(__('Контактний email'))
                                    ->email()
                                    ->maxLength(255)
                                    ->nullable(),

                                TextInput::make('phone')
                                    ->label(__('Телефон'))
                                    ->maxLength(20)
                                    ->nullable(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('logo')
                    ->label(__('Логотип'))
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('logo'))
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-publisher-logo.jpg')),

                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.publishers.view', $record->id)),

                TextColumn::make('country')
                    ->label(__('Країна'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('founded_year')
                    ->label(__('Рік заснування'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('contact_email')
                    ->label(__('Контактний email'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('books_count')
                    ->label(__('Кількість книг'))
                    ->counts('books')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('country')
                    ->label(__('Країна'))
                    ->options(fn () => Publisher::pluck('country', 'country')->filter()->toArray())
                    ->multiple()
                    ->indicator(__('Країна')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ])
            ->defaultSort('name', 'asc')
            ->groups([
                'country',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPublishers::route('/'),
            'create' => CreatePublisher::route('/create'),
            'view' => ViewPublisher::route('/{record}'),
            'edit' => EditPublisher::route('/{record}/edit'),
        ];
    }
}
