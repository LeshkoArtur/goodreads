<?php

namespace App\Filament\Admin\Resources;

use App\Enums\QuestionStatus;
use App\Filament\Admin\Resources\AuthorQuestionResource\Pages;
use App\Models\AuthorQuestion;
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

class AuthorQuestionResource extends Resource
{
    protected static ?string $model = AuthorQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Зв\'язок з автором';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'content';

    public static function getModelLabel(): string
    {
        return 'Питання до автора';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Питання до авторів';
    }

    public static function getNavigationLabel(): string
    {
        return 'Питання до авторів';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->content;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Автор' => $record->author->name,
            'Користувач' => $record->user->username,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['author', 'user', 'book']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Інформація про питання та учасників')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач')
                            ->helperText('Хто задав питання'),
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Автор')
                            ->helperText('Кому адресоване питання'),
                        Select::make('book_id')
                            ->relationship('book', 'title')
                            ->searchable()
                            ->preload()
                            ->label('Книга (опціонально)')
                            ->helperText('Книга, з якою пов\'язане питання'),
                        Select::make('status')
                            ->options(QuestionStatus::class)
                            ->required()
                            ->default(QuestionStatus::PENDING)
                            ->native(false)
                            ->label('Статус')
                            ->helperText('Статус обробки питання'),
                        RichEditor::make('content')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->label('Текст питання'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')
                    ->label('Питання')
                    ->limit(50)
                    ->tooltip(fn (AuthorQuestion $record): ?string => $record->content)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable()
                    ->description(fn (AuthorQuestion $record): string => $record->user->email ?? ''
                    ),
                TextColumn::make('author.name')
                    ->label('Автор')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Автор'),
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Користувач'),
                SelectFilter::make('status')
                    ->options(QuestionStatus::class)
                    ->native(false)
                    ->multiple()
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
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            AuthorQuestionResource\RelationManagers\AnswersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthorQuestions::route('/'),
            'create' => Pages\CreateAuthorQuestion::route('/create'),
            'view' => Pages\ViewAuthorQuestion::route('/{record}'),
            'edit' => Pages\EditAuthorQuestion::route('/{record}/edit'),
        ];
    }
}
