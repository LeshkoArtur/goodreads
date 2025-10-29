<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AnswerStatus;
use App\Filament\Admin\Resources\AuthorAnswerResource\Pages;
use App\Models\AuthorAnswer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class AuthorAnswerResource extends Resource
{
    protected static ?string $model = AuthorAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Зв\'язок з автором';

    protected static ?int $navigationSort = 31;

    protected static ?string $recordTitleAttribute = 'content';

    public static function getModelLabel(): string
    {
        return 'Відповідь автора';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Відповіді авторів';
    }

    public static function getNavigationLabel(): string
    {
        return 'Відповіді авторів';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->content;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Автор' => $record->author->name,
            'Питання' => $record->question->content,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['author', 'question']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->schema([
                        Select::make('question_id')
                            ->relationship('question', 'content')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Питання'),
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Автор'),
                        RichEditor::make('content')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->label('Відповідь'),
                    ])
                    ->columns(2),

                Section::make('Публікація')
                    ->schema([
                        DateTimePicker::make('published_at')
                            ->label('Дата публікації')
                            ->native(false),
                        Select::make('status')
                            ->options(AnswerStatus::class)
                            ->required()
                            ->default(AnswerStatus::PENDING)
                            ->native(false)
                            ->label('Статус'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question.content')
                    ->label('Питання')
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Автор')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge(),
                TextColumn::make('likes_count')
                    ->counts('likes')
                    ->label('Лайки')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('author')
                    ->relationship('author', 'name')
                    ->label('Автор'),
                SelectFilter::make('status')
                    ->options(AnswerStatus::class)
                    ->label('Статус'),
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
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAuthorAnswers::route('/'),
            'create' => Pages\CreateAuthorAnswer::route('/create'),
            'view' => Pages\ViewAuthorAnswer::route('/{record}'),
            'edit' => Pages\EditAuthorAnswer::route('/{record}/edit'),
        ];
    }
}
