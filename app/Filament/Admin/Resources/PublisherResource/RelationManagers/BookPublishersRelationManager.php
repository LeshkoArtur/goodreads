<?php

namespace App\Filament\Admin\Resources\PublisherResource\RelationManagers;

use App\Enums\CoverType;
use App\Enums\ReadingFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookPublishersRelationManager extends RelationManager
{
    protected static string $relationship = 'bookPublishers';

    protected static ?string $title = 'Історія публікацій';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('book_id')
                    ->label('Книга')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('published_date')
                    ->label('Дата публікації')
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN')
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('circulation')
                    ->label('Тираж')
                    ->numeric()
                    ->minValue(1),
                Forms\Components\Select::make('format')
                    ->label('Формат')
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
                    ->prefix('₴')
                    ->minValue(0),
                Forms\Components\TextInput::make('translator')
                    ->label('Перекладач')
                    ->maxLength(255),
                Forms\Components\TextInput::make('edition')
                    ->label('Видання')
                    ->maxLength(100)
                    ->helperText('Наприклад: 2-ге видання, перевидання'),
                Forms\Components\TextInput::make('binding')
                    ->label('Палітурка')
                    ->maxLength(100),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['book.authors'])
            )
            ->columns([
                Tables\Columns\ImageColumn::make('book.cover_image')
                    ->label('Обкладинка')
                    ->disk('public')
                    ->size(50),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->book->authors->pluck('name')->join(', ')),
                Tables\Columns\TextColumn::make('published_date')
                    ->label('Дата публікації')
                    ->date('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('circulation')
                    ->label('Тираж')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('format')
                    ->label('Формат')
                    ->badge(),
                Tables\Columns\TextColumn::make('cover_type')
                    ->label('Обкладинка')
                    ->badge(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Ціна')
                    ->money('UAH')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('translator')
                    ->label('Перекладач')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('edition')
                    ->label('Видання')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_date', 'desc')
            ->emptyStateHeading('Немає публікацій')
            ->emptyStateDescription('Додайте першу публікацію книги цим видавництвом')
            ->emptyStateIcon('heroicon-o-book-open');
    }
}
