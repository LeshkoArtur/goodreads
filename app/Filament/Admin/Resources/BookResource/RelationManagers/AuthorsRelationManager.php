<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use App\Enums\TypeOfWork;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AuthorsRelationManager extends RelationManager
{
    protected static string $relationship = 'authors';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Автори книги') . ' ' . $ownerRecord->title;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Ім\'я автора'))
                    ->required()
                    ->maxLength(100),

                Textarea::make('bio')
                    ->label(__('Біографія'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                DatePicker::make('birth_date')
                    ->label(__('Дата народження'))
                    ->nullable()
                    ->maxDate(now()),

                TextInput::make('birth_place')
                    ->label(__('Місце народження'))
                    ->maxLength(100)
                    ->nullable(),

                TextInput::make('nationality')
                    ->label(__('Національність'))
                    ->maxLength(50)
                    ->nullable(),

                TextInput::make('website')
                    ->label(__('Вебсайт'))
                    ->url()
                    ->maxLength(255)
                    ->nullable(),

                DatePicker::make('death_date')
                    ->label(__('Дата смерті'))
                    ->nullable()
                    ->maxDate(now()),

                Forms\Components\FileUpload::make('profile_picture')
                    ->label(__('Фото профілю'))
                    ->collection('profile_picture')
                    ->image()
                    ->maxSize(2048)
                    ->nullable(),

                KeyValue::make('social_media_links')
                    ->label(__('Соціальні мережі'))
                    ->keyLabel(__('Платформа'))
                    ->valueLabel(__('URL'))
                    ->nullable(),

                KeyValue::make('media_images')
                    ->label(__('Медіа зображення'))
                    ->keyLabel(__('Назва'))
                    ->valueLabel(__('URL'))
                    ->nullable(),

                KeyValue::make('media_videos')
                    ->label(__('Медіа відео'))
                    ->keyLabel(__('Назва'))
                    ->valueLabel(__('URL'))
                    ->nullable(),

                KeyValue::make('fun_facts')
                    ->label(__('Цікаві факти'))
                    ->keyLabel(__('Факт'))
                    ->valueLabel(__('Опис'))
                    ->nullable(),

                Select::make('type_of_work')
                    ->label(__('Тип роботи'))
                    ->options(TypeOfWork::class)
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_picture')
                    ->label(__('Фото'))
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('profile_picture'))
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-author-image.jpg')),

                TextColumn::make('name')
                    ->label(__('Ім\'я'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.authors.view', $record->id)),

                TextColumn::make('nationality')
                    ->label(__('Національність'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('birth_date')
                    ->label(__('Дата народження'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('death_date')
                    ->label(__('Дата смерті'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('type_of_work')
                    ->label(__('Тип роботи'))
                    ->badge()
                    ->formatStateUsing(fn (?TypeOfWork $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('books_count')
                    ->label(__('Кількість книг'))
                    ->counts('books')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type_of_work')
                    ->label(__('Тип роботи'))
                    ->options(TypeOfWork::class)
                    ->multiple()
                    ->indicator(__('Тип роботи')),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('Додати автора'))
                    ->preloadRecordSelect(),
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
