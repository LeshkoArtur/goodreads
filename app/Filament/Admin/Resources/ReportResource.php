<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Filament\Admin\Resources\ReportResource\Pages;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Report;
use App\Models\User;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Системні та допоміжні';

    protected static ?int $navigationSort = 37;

    public static function getModelLabel(): string
    {
        return 'Скарга';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Скарги';
    }

    public static function getNavigationLabel(): string
    {
        return 'Скарги';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'reportable']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про скаргу')
                    ->description('Основні дані про скаргу')
                    ->schema([
                        Select::make('user_id')
                            ->label('Хто подав скаргу')
                            ->relationship('user', 'username')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Користувач, який подав скаргу')
                            ->columnSpan(1),
                        Select::make('type')
                            ->label('Тип скарги')
                            ->options(ReportType::class)
                            ->required()
                            ->native(false)
                            ->helperText('Категорія порушення')
                            ->columnSpan(1),
                        Select::make('status')
                            ->label('Статус обробки')
                            ->options(ReportStatus::class)
                            ->required()
                            ->default(ReportStatus::PENDING)
                            ->native(false)
                            ->helperText('Статус розгляду скарги модератором')
                            ->columnSpan(1),
                    ])->columns(3),

                Section::make('Об\'єкт скарги')
                    ->description('На що подано скаргу')
                    ->schema([
                        MorphToSelect::make('reportable')
                            ->label('Об\'єкт скарги')
                            ->types([
                                MorphToSelect\Type::make(User::class)
                                    ->titleAttribute('username')
                                    ->label('Користувач'),
                                MorphToSelect\Type::make(Book::class)
                                    ->titleAttribute('title')
                                    ->label('Книга'),
                                MorphToSelect\Type::make(Comment::class)
                                    ->titleAttribute('content')
                                    ->label('Коментар'),
                                MorphToSelect\Type::make(Post::class)
                                    ->titleAttribute('title')
                                    ->label('Пост'),
                                MorphToSelect\Type::make(Quote::class)
                                    ->titleAttribute('content')
                                    ->label('Цитата'),
                            ])
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Опис проблеми')
                            ->rows(5)
                            ->maxLength(2000)
                            ->helperText('Детальний опис причини скарги (до 2000 символів)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label('Хто подав')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Report $record): string => $record->user->email ?? ''
                    ),
                TextColumn::make('type')
                    ->label('Тип скарги')
                    ->badge()
                    ->color(fn (?ReportType $state): string|array|null => $state?->getColor())
                    ->sortable()
                    ->searchable(),
                TextColumn::make('reportable_type')
                    ->label('Об\'єкт')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'App\\Models\\User' => 'Користувач',
                        'App\\Models\\Book' => 'Книга',
                        'App\\Models\\Comment' => 'Коментар',
                        'App\\Models\\Post' => 'Пост',
                        'App\\Models\\Quote' => 'Цитата',
                        default => class_basename($state),
                    }
                    )
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (?ReportStatus $state): string|array|null => $state?->getColor())
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Опис')
                    ->limit(50)
                    ->tooltip(fn (Report $record): ?string => $record->description)
                    ->wrap()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Дата подачі')
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
                SelectFilter::make('user')
                    ->label('Хто подав')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('type')
                    ->label('Тип скарги')
                    ->options(ReportType::class)
                    ->native(false)
                    ->multiple(),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(ReportStatus::class)
                    ->native(false)
                    ->multiple(),
                SelectFilter::make('reportable_type')
                    ->label('Тип об\'єкту')
                    ->options([
                        'App\\Models\\User' => 'Користувач',
                        'App\\Models\\Book' => 'Книга',
                        'App\\Models\\Comment' => 'Коментар',
                        'App\\Models\\Post' => 'Пост',
                        'App\\Models\\Quote' => 'Цитата',
                    ])
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
