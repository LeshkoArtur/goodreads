<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PublishersRelationManager extends RelationManager
{
    protected static string $relationship = 'publishers';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Видавці книги') . ' ' . $ownerRecord->title;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Назва видавця'))
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

                DatePicker::make('pivot.published_date')
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
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

                TextColumn::make('pivot.cover_type')
                    ->label(__('Тип обкладинки'))
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'glossy' => __('Глянцева'),
                        'matte' => __('Матова'),
                        'embossed' => __('Рельєфна'),
                        default => $state ?? '-',
                    })
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('country')
                    ->label(__('Країна'))
                    ->options(fn () => \App\Models\Publisher::pluck('country', 'country')->filter()->toArray())
                    ->multiple()
                    ->indicator(__('Країна')),

                Tables\Filters\SelectFilter::make('pivot.format')
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
                    ->label(__('Додати видавця'))
                    ->preloadRecordSelect()
                    ->form(fn (Forms\Form $form) => $form->schema([
                        Select::make('recordId')
                            ->label(__('Видавець'))
                            ->relationship('publishers', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        DatePicker::make('published_date')
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
                        ->label(__('Від’єднати вибраних')),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
