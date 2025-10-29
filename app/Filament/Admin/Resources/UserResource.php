<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Gender;
use App\Enums\Role;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Основні сутності';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'username';

    public static function getModelLabel(): string
    {
        return 'Користувач';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Користувачі';
    }

    public static function getNavigationLabel(): string
    {
        return 'Користувачі';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['username', 'email', 'bio'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->username;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Email' => $record->email,
            'Роль' => $record->role->getLabel(),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['shelves', 'books', 'ratings', 'quotes', 'comments']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_picture')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                TextColumn::make('username')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (Role $state): string|array|null => $state->getColor()),
                TextColumn::make('gender')
                    ->badge()
                    ->color(fn (?Gender $state): string|array|null => $state?->getColor())
                    ->toggleable(),
                IconColumn::make('is_public')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('shelves_count')
                    ->label('Полиці')
                    ->badge()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('books_count')
                    ->label('Книги')
                    ->badge()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('ratings_count')
                    ->label('Оцінки')
                    ->badge()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Реєстрація')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_login')
                    ->label('Останній вхід')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options(Role::class)
                    ->label('Роль'),
                SelectFilter::make('gender')
                    ->options(Gender::class)
                    ->label('Стать'),
                TernaryFilter::make('is_public')
                    ->label('Публічний профіль'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Від')
                            ->native(false),
                        DatePicker::make('created_until')
                            ->label('До')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
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
                    ->description('Базова інформація про користувача')
                    ->schema([
                        TextInput::make('username')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->columnSpan(1),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->helperText('Залиште порожнім, щоб не змінювати пароль')
                            ->columnSpan(1),
                        FileUpload::make('profile_picture')
                            ->image()
                            ->disk('public')
                            ->directory('profiles')
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('500')
                            ->imageResizeTargetHeight('500')
                            ->columnSpan(1),
                        Textarea::make('bio')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Персональна інформація')
                    ->schema([
                        DatePicker::make('birthday')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()->subYears(13))
                            ->columnSpan(1),
                        TextInput::make('location')
                            ->maxLength(100)
                            ->columnSpan(1),
                        Select::make('gender')
                            ->options(Gender::class)
                            ->native(false)
                            ->columnSpan(1),
                        Toggle::make('is_public')
                            ->default(true)
                            ->helperText('Публічні профілі видимі всім користувачам')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Система')
                    ->schema([
                        Select::make('role')
                            ->options(Role::class)
                            ->required()
                            ->default(Role::USER)
                            ->native(false)
                            ->columnSpan(1),
                        DateTimePicker::make('email_verified_at')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->columnSpan(1),
                        KeyValue::make('social_media_links')
                            ->keyLabel('Платформа')
                            ->valueLabel('URL')
                            ->reorderable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserResource\RelationManagers\ShelvesRelationManager::class,
            UserResource\RelationManagers\BooksRelationManager::class,
            UserResource\RelationManagers\RatingsRelationManager::class,
            UserResource\RelationManagers\QuotesRelationManager::class,
            UserResource\RelationManagers\CommentsRelationManager::class,
            UserResource\RelationManagers\GroupsRelationManager::class,
            UserResource\RelationManagers\AuthorsRelationManager::class,
            UserResource\RelationManagers\FollowingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
