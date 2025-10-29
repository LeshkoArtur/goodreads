<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CharacterResource\Pages;
use App\Models\Character;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
use Illuminate\Database\Eloquent\Model;

class CharacterResource extends Resource
{
    protected static ?string $model = Character::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Деталізація книги';

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'Персонаж';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Персонажі';
    }

    public static function getNavigationLabel(): string
    {
        return 'Персонажі';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Книга' => $record->book->title,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('book');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Базові дані про персонажа')
                    ->schema([
                        Select::make('book_id')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Книга')
                            ->helperText('Книга, де з\'являється персонаж'),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Ім\'я персонажа')
                            ->helperText('Повне ім\'я персонажа'),
                        RichEditor::make('biography')
                            ->label('Біографія')
                            ->helperText('Історія та опис персонажа')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Додаткова інформація')
                    ->description('Детальні характеристики персонажа')
                    ->schema([
                        TextInput::make('race')
                            ->maxLength(50)
                            ->label('Раса')
                            ->helperText('Наприклад: ельф, чарівник, людина'),
                        TextInput::make('nationality')
                            ->maxLength(50)
                            ->label('Національність'),
                        TextInput::make('residence')
                            ->maxLength(100)
                            ->label('Місце проживання'),
                        KeyValue::make('other_names')
                            ->label('Інші імена')
                            ->keyLabel('Тип')
                            ->valueLabel('Ім\'я')
                            ->helperText('Псевдоніми, прізвиська, інші імена'),
                        KeyValue::make('fun_facts')
                            ->label('Цікаві факти'),
                        KeyValue::make('links')
                            ->label('Посилання')
                            ->keyLabel('Сайт')
                            ->valueLabel('URL'),
                    ])->columns(3),

                Section::make('Медіа')
                    ->description('Зображення персонажа')
                    ->schema([
                        FileUpload::make('media_images')
                            ->label('Зображення')
                            ->image()
                            ->disk('public')
                            ->directory('characters')
                            ->imageEditor()
                            ->multiple()
                            ->reorderable()
                            ->visibility('public'),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Ім\'я')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(fn (Character $record): ?string => $record->book->title),
                TextColumn::make('race')
                    ->label('Раса')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                TextColumn::make('nationality')
                    ->label('Національність')
                    ->searchable()
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
                SelectFilter::make('book')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Книга'),
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
            ->defaultSort('name')
            ->striped();
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
            'index' => Pages\ListCharacters::route('/'),
            'create' => Pages\CreateCharacter::route('/create'),
            'view' => Pages\ViewCharacter::route('/{record}'),
            'edit' => Pages\EditCharacter::route('/{record}/edit'),
        ];
    }
}
