<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ViewHistoryResource\Pages;
use App\Models\Book;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\ViewHistory;
use Filament\Forms\Components\MorphToSelect;
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

class ViewHistoryResource extends Resource
{
    protected static ?string $model = ViewHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationGroup = 'Взаємодія користувача';

    protected static ?int $navigationSort = 19;

    public static function getModelLabel(): string
    {
        return 'Історія переглядів';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Історія переглядів';
    }

    public static function getNavigationLabel(): string
    {
        return 'Історія переглядів';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'viewable']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Історія переглядів')
                    ->description('Перегляд контенту користувачем')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Користувач')
                            ->helperText('Хто переглядав'),
                        MorphToSelect::make('viewable')
                            ->label('Об\'кт перегляду')
                            ->types([
                                MorphToSelect\Type::make(Book::class)->titleAttribute('title')->label('Книга'),
                                MorphToSelect\Type::make(Post::class)->titleAttribute('title')->label('Пост'),
                                MorphToSelect\Type::make(GroupPost::class)->titleAttribute('content')->label('Пост групи'),
                            ])
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label('Користувач')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('viewable_type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Book::class => 'Книга',
                        Post::class => 'Пост',
                        GroupPost::class => 'Пост групи',
                        default => $state,
                    })
                    ->badge(),
                TextColumn::make('viewable.title')
                    ->label('Назва/Ім\'я')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата перегляду')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Користувач'),
                SelectFilter::make('viewable_type')
                    ->options([
                        Book::class => 'Книга',
                        Post::class => 'Пост',
                        GroupPost::class => 'Пост групи',
                    ])
                    ->label('Тип'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListViewHistories::route('/'),
            'create' => Pages\CreateViewHistory::route('/create'),
            'view' => Pages\ViewViewHistory::route('/{record}'),
            'edit' => Pages\EditViewHistory::route('/{record}/edit'),
        ];
    }
}
