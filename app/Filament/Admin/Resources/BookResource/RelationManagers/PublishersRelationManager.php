<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use App\Enums\CoverType;
use App\Enums\ReadingFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class PublishersRelationManager extends RelationManager
{
    protected static string $relationship = 'publishers';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Видавництва';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Логотип')
                    ->size(40)
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('published_date')
                    ->label('Дата публікації')
                    ->date('d.m.Y')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('format')
                    ->label('Формат')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('cover_type')
                    ->label('Тип обкладинки')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Ціна')
                    ->money('UAH')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('format')
                    ->label('Формат')
                    ->options(ReadingFormat::class),
                Tables\Filters\SelectFilter::make('cover_type')
                    ->label('Тип обкладинки')
                    ->options(CoverType::class),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити видавництво')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'country'])
                    ->modalHeading('Прикріпити видавництво до книги')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Section::make('Деталі публікації')
                            ->schema([
                                Forms\Components\DatePicker::make('published_date')
                                    ->label('Дата публікації')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now()),
                                Forms\Components\TextInput::make('isbn')
                                    ->label('ISBN')
                                    ->maxLength(20)
                                    ->helperText('ISBN-10 або ISBN-13'),
                                Forms\Components\Select::make('format')
                                    ->label('Формат видання')
                                    ->options(ReadingFormat::class)
                                    ->required()
                                    ->native(false)
                                    ->default(ReadingFormat::PHYSICAL),
                                Forms\Components\Select::make('cover_type')
                                    ->label('Тип обкладинки')
                                    ->options(CoverType::class)
                                    ->required()
                                    ->native(false)
                                    ->default(CoverType::PAPERBACK),
                                Forms\Components\TextInput::make('price')
                                    ->label('Ціна')
                                    ->numeric()
                                    ->prefix('₴')
                                    ->minValue(0)
                                    ->step(0.01),
                                Forms\Components\TextInput::make('circulation')
                                    ->label('Тираж')
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix('екз.'),
                                Forms\Components\TextInput::make('translator')
                                    ->label('Перекладач')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('edition')
                                    ->label('Видання')
                                    ->maxLength(50)
                                    ->helperText('Наприклад: 2-ге видання'),
                                Forms\Components\TextInput::make('binding')
                                    ->label('Палітурка')
                                    ->maxLength(50),
                            ])
                            ->columns(3),
                    ]),
                Tables\Actions\CreateAction::make()
                    ->label('Створити видавництво')
                    ->modalHeading('Створити нове видавництво'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редагувати')
                    ->modalHeading('Редагувати деталі публікації')
                    ->form([
                        Forms\Components\DatePicker::make('published_date')
                            ->label('Дата публікації')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->maxLength(20),
                        Forms\Components\Select::make('format')
                            ->label('Формат видання')
                            ->options(ReadingFormat::class)
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('cover_type')
                            ->label('Тип обкладинки')
                            ->options(CoverType::class)
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('price')
                            ->label('Ціна')
                            ->numeric()
                            ->prefix('₴'),
                        Forms\Components\TextInput::make('circulation')
                            ->label('Тираж')
                            ->numeric()
                            ->suffix('екз.'),
                        Forms\Components\TextInput::make('translator')
                            ->label('Перекладач')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('edition')
                            ->label('Видання')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('binding')
                            ->label('Палітурка')
                            ->maxLength(50),
                    ]),
                Tables\Actions\DetachAction::make()
                    ->label('Відкріпити')
                    ->requiresConfirmation()
                    ->modalHeading('Відкріпити видавництво?')
                    ->modalDescription('Видавництво буде відкріплено від цієї книги.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Відкріпити обрані')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Немає видавництв')
            ->emptyStateDescription('Додайте видавництво до цієї книги.')
            ->emptyStateActions([
                Tables\Actions\AttachAction::make()
                    ->label('Прикріпити видавництво')
                    ->preloadRecordSelect(),
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основна інформація')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Назва видавництва')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('logo')
                            ->label('Логотип')
                            ->image()
                            ->disk('public')
                            ->directory('publishers'),
                        Forms\Components\Textarea::make('description')
                            ->label('Опис')
                            ->rows(3)
                            ->maxLength(1000),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Контактна інформація')
                    ->schema([
                        Forms\Components\TextInput::make('website')
                            ->label('Веб-сайт')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->label('Країна')
                            ->maxLength(100),
                    ])
                    ->columns(3)
                    ->collapsed(),
            ]);
    }
}
