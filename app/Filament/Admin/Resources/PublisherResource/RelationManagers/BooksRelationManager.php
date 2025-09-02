<?php

namespace App\Filament\Admin\Resources\PublisherResource\RelationManagers;

use App\Enums\AgeRestriction;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Книги видавця') . ' ' . $ownerRecord->name;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('Назва'))
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label(__('Опис'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                Textarea::make('plot')
                    ->label(__('Сюжет'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                Textarea::make('history')
                    ->label(__('Історія створення'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                Select::make('series_id')
                    ->label(__('Серія'))
                    ->relationship('series', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('number_in_series')
                    ->label(__('Номер у серії'))
                    ->numeric()
                    ->minValue(1)
                    ->nullable(),

                TextInput::make('page_count')
                    ->label(__('Кількість сторінок'))
                    ->numeric()
                    ->minValue(1)
                    ->nullable(),

                KeyValue::make('languages')
                    ->label(__('Мови'))
                    ->keyLabel(__('Код мови'))
                    ->valueLabel(__('Назва мови'))
                    ->nullable(),

                Forms\Components\FileUpload::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->directory('cover_image')
                    ->image()
                    ->maxSize(2048)
                    ->nullable(),

                KeyValue::make('fun_facts')
                    ->label(__('Цікаві факти'))
                    ->keyLabel(__('Факт'))
                    ->valueLabel(__('Опис'))
                    ->nullable(),

                KeyValue::make('adaptations')
                    ->label(__('Екранізації'))
                    ->keyLabel(__('Назва'))
                    ->valueLabel(__('Опис'))
                    ->nullable(),

                Toggle::make('is_bestseller')
                    ->label(__('Бестселер'))
                    ->default(false),

                TextInput::make('average_rating')
                    ->label(__('Середній рейтинг'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(5)
                    ->step(0.1)
                    ->disabled()
                    ->dehydrated(false),

                Select::make('age_restriction')
                    ->label(__('Вікове обмеження'))
                    ->options(AgeRestriction::class)
                    ->nullable(),

                Forms\Components\Section::make(__('Дані видавця'))
                    ->schema([
                        Forms\Components\DatePicker::make('pivot.published_date')
                            ->label(__('Дата публікації'))
                            ->nullable(),

                        TextInput::make('pivot.isbn')
                            ->label(__('ISBN'))
                            ->maxLength(13)
                            ->nullable(),

                        TextInput::make('pivot.circulation')
                            ->label(__('Наклад'))
                            ->numeric()
                            ->minValue(1)
                            ->nullable(),

                        Select::make('pivot.format')
                            ->label(__('Формат'))
                            ->options([
                                'hardcover' => __('Тверда обкладинка'),
                                'paperback' => __('М’яка обкладинка'),
                                'ebook' => __('Електронна книга'),
                                'audiobook' => __('Аудіокнига'),
                            ])
                            ->nullable(),

                        Select::make('pivot.cover_type')
                            ->label(__('Тип обкладинки'))
                            ->options([
                                'glossy' => __('Глянцева'),
                                'matte' => __('Матова'),
                                'embossed' => __('Рельєфна'),
                            ])
                            ->nullable(),

                        TextInput::make('pivot.translator')
                            ->label(__('Перекладач'))
                            ->maxLength(100)
                            ->nullable(),

                        TextInput::make('pivot.edition')
                            ->label(__('Видання'))
                            ->numeric()
                            ->minValue(1)
                            ->nullable(),

                        TextInput::make('pivot.price')
                            ->label(__('Ціна'))
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01)
                            ->nullable(),

                        Select::make('pivot.binding')
                            ->label(__('Палітурка'))
                            ->options([
                                'stitched' => __('Прошита'),
                                'glued' => __('Клеєна'),
                                'spiral' => __('Спіральна'),
                            ])
                            ->nullable(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('cover_image'))
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-book-image.jpg')),

                TextColumn::make('title')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.books.view', $record->id)),

                TextColumn::make('series.name')
                    ->label(__('Серія'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('number_in_series')
                    ->label(__('Номер у серії'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('page_count')
                    ->label(__('Сторінки'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('average_rating')
                    ->label(__('Середній рейтинг'))
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_bestseller')
                    ->label(__('Бестселер'))
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('age_restriction')
                    ->label(__('Вікове обмеження'))
                    ->badge()
                    ->formatStateUsing(fn (?AgeRestriction $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pivot.published_date')
                    ->label(__('Дата публікації'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pivot.isbn')
                    ->label(__('ISBN'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pivot.circulation')
                    ->label(__('Наклад'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pivot.format')
                    ->label(__('Формат'))
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'hardcover' => __('Тверда обкладинка'),
                        'paperback' => __('М’яка обкладинка'),
                        'ebook' => __('Електронна книга'),
                        'audiobook' => __('Аудіокнига'),
                        default => $state ?? '-',
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('ratings_count')
                    ->label(__('Кількість рейтингів'))
                    ->counts('ratings')
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
                SelectFilter::make('age_restriction')
                    ->label(__('Вікове обмеження'))
                    ->options(AgeRestriction::class)
                    ->multiple()
                    ->indicator(__('Вікове обмеження')),

                TernaryFilter::make('is_bestseller')
                    ->label(__('Бестселер'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Бестселери'))
                    ->falseLabel(__('Не бестселери'))
                    ->indicator(__('Бестселер')),

                SelectFilter::make('series_id')
                    ->label(__('Серія'))
                    ->relationship('series', 'name')
                    ->multiple()
                    ->indicator(__('Серія')),

                SelectFilter::make('pivot.format')
                    ->label(__('Формат'))
                    ->options([
                        'hardcover' => __('Тверда обкладинка'),
                        'paperback' => __('М’яка обкладинка'),
                        'ebook' => __('Електронна книга'),
                        'audiobook' => __('Аудіокнига'),
                    ])
                    ->multiple()
                    ->indicator(__('Формат')),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('Додати книгу'))
                    ->preloadRecordSelect()
                    ->form(fn (Forms\Form $form) => $form->schema([
                        Select::make('recordId')
                            ->label(__('Книга'))
                            ->relationship('books', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\DatePicker::make('published_date')
                            ->label(__('Дата публікації'))
                            ->nullable(),

                        TextInput::make('isbn')
                            ->label(__('ISBN'))
                            ->maxLength(13)
                            ->nullable(),

                        TextInput::make('circulation')
                            ->label(__('Наклад'))
                            ->numeric()
                            ->minValue(1)
                            ->nullable(),

                        Select::make('format')
                            ->label(__('Формат'))
                            ->options([
                                'hardcover' => __('Тверда обкладинка'),
                                'paperback' => __('М’яка обкладинка'),
                                'ebook' => __('Електронна книга'),
                                'audiobook' => __('Аудіокнига'),
                            ])
                            ->nullable(),

                        Select::make('cover_type')
                            ->label(__('Тип обкладинки'))
                            ->options([
                                'glossy' => __('Глянцева'),
                                'matte' => __('Матова'),
                                'embossed' => __('Рельєфна'),
                            ])
                            ->nullable(),

                        TextInput::make('translator')
                            ->label(__('Перекладач'))
                            ->maxLength(100)
                            ->nullable(),

                        TextInput::make('edition')
                            ->label(__('Видання'))
                            ->numeric()
                            ->minValue(1)
                            ->nullable(),

                        TextInput::make('price')
                            ->label(__('Ціна'))
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01)
                            ->nullable(),

                        Select::make('binding')
                            ->label(__('Палітурка'))
                            ->options([
                                'stitched' => __('Прошита'),
                                'glued' => __('Клеєна'),
                                'spiral' => __('Спіральна'),
                            ])
                            ->nullable(),
                    ])),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати')),
                Tables\Actions\DetachAction::make()
                    ->label(__('Від’єднати')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label(__('Від’єднати вибрані')),
                ]),
            ])
            ->defaultSort('title', 'asc');
    }
}
