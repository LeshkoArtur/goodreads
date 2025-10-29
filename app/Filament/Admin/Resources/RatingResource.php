<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RatingResource\Pages;
use App\Models\Rating;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 10;

    public static function getModelLabel(): string
    {
        return 'Рейтинг';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Рейтинги';
    }

    public static function getNavigationLabel(): string
    {
        return 'Рейтинги';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['review', 'user.username', 'book.title'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->user->username.' → '.$record->book->title;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Рейтинг' => $record->rating.' ⭐',
            'Книга' => $record->book->title,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['comments', 'likes']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('book.title')
                    ->label('Книга')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('rating')
                    ->label('Оцінка')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        $state >= 2 => 'info',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => $state.' ⭐'),
                TextColumn::make('review')
                    ->label('Відгук')
                    ->limit(50)
                    ->html()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('comments_count')
                    ->label('Коментарів')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('likes_count')
                    ->label('Лайків')
                    ->badge()
                    ->color('success')
                    ->sortable()
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
                Filter::make('rating')
                    ->form([
                        Select::make('rating_from')
                            ->label('Оцінка від')
                            ->options([1 => '1⭐', 2 => '2⭐', 3 => '3⭐', 4 => '4⭐', 5 => '5⭐'])
                            ->native(false),
                        Select::make('rating_to')
                            ->label('Оцінка до')
                            ->options([1 => '1⭐', 2 => '2⭐', 3 => '3⭐', 4 => '4⭐', 5 => '5⭐'])
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['rating_from'], fn (Builder $query, $rating) => $query->where('rating', '>=', $rating))
                            ->when($data['rating_to'], fn (Builder $query, $rating) => $query->where('rating', '<=', $rating));
                    }),
                SelectFilter::make('user')
                    ->label('Користувач')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('book')
                    ->label('Книга')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple(),
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
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Оцінка книги користувачем')
                    ->schema([
                        Select::make('user_id')
                            ->label('Користувач')
                            ->helperText('Автор оцінки')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('book_id')
                            ->label('Книга')
                            ->helperText('Книга, яку оцінюють')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('rating')
                            ->label('Оцінка')
                            ->helperText('Від 1 до 5 зірок')
                            ->options([
                                1 => '1 ⭐',
                                2 => '2 ⭐⭐',
                                3 => '3 ⭐⭐⭐',
                                4 => '4 ⭐⭐⭐⭐',
                                5 => '5 ⭐⭐⭐⭐⭐',
                            ])
                            ->required()
                            ->native(false),
                    ])
                    ->columns(3),

                Section::make('Рецензія')
                    ->description('Детальний відгук про книгу')
                    ->schema([
                        RichEditor::make('review')
                            ->label('Відгук')
                            ->helperText('Опціонально - детальний відгук про книгу')
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RatingResource\RelationManagers\CommentsRelationManager::class,
            RatingResource\RelationManagers\LikesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRatings::route('/'),
            'create' => Pages\CreateRating::route('/create'),
            'view' => Pages\ViewRating::route('/{record}'),
            'edit' => Pages\EditRating::route('/{record}/edit'),
        ];
    }
}
