<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use App\Enums\TypeOfWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AuthorsRelationManager extends RelationManager
{
    protected static string $relationship = 'authors';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Автори';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основна інформація')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Ім\'я автора')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('profile_picture')
                            ->label('Фото')
                            ->image()
                            ->disk('public')
                            ->directory('authors')
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1'),
                        Forms\Components\Textarea::make('bio')
                            ->label('Біографія')
                            ->rows(4)
                            ->maxLength(1000),
                        Forms\Components\Select::make('type_of_work')
                            ->label('Тип творчості')
                            ->options(TypeOfWork::class)
                            ->native(false),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Персональна інформація')
                    ->schema([
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Дата народження')
                            ->native(false),
                        Forms\Components\TextInput::make('birth_place')
                            ->label('Місце народження')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nationality')
                            ->label('Національність')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('website')
                            ->label('Веб-сайт')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Фото')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ім\'я')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('nationality')
                    ->label('Національність')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type_of_work')
                    ->label('Тип творчості')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Дата народження')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Книг')
                    ->counts('books')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('nationality')
                    ->label('Національність')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('type_of_work')
                    ->label('Тип творчості')
                    ->options(TypeOfWork::class),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити автора')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'nationality'])
                    ->modalHeading('Прикріпити автора до книги'),
                Tables\Actions\CreateAction::make()
                    ->label('Створити автора')
                    ->modalHeading('Створити нового автора'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label('Відкріпити')
                    ->requiresConfirmation()
                    ->modalHeading('Відкріпити автора?')
                    ->modalDescription('Автор буде відкріплений від цієї книги, але залишиться в системі.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Відкріпити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Немає авторів')
            ->emptyStateDescription('Додайте автора до цієї книги.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити автора')
                    ->preloadRecordSelect(),
            ]);
    }
}
