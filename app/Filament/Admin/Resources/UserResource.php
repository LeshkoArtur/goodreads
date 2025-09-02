<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Filament\Admin\Resources\UserResource\Pages\CreateUser;
use App\Filament\Admin\Resources\UserResource\Pages\EditUser;
use App\Filament\Admin\Resources\UserResource\Pages\ViewUser;
use App\Filament\Admin\Resources\UserResource\RelationManagers\CommentsRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\GroupsRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\QuotesRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\RatingsRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\ShelvesRelationManager;

use App\Enums\Gender;
use App\Enums\Role;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Користувачі';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Користувачі');
    }

    public static function getModelLabel(): string
    {
        return __('Користувач');
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function getPluralModelLabel(): string
    {
        return __('Користувачі');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make(__('Користувач'))
                    ->tabs([
                        Tab::make(__('Основна інформація'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('username')
                                            ->label(__('Ім\'я користувача'))
                                            ->required()
                                            ->maxLength(50)
                                            ->rules(['string', 'min:3', 'unique:users,username,{{resourceId}}']),

                                        TextInput::make('email')
                                            ->label(__('Email'))
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(User::class, 'email', ignoreRecord: true),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('role')
                                            ->label(__('Роль'))
                                            ->options(Role::class)
                                            ->required()
                                            ->disabled(fn () => auth()->user()->role !== Role::ADMIN),

                                        Select::make('gender')
                                            ->label(__('Стать'))
                                            ->options(Gender::class)
                                            ->nullable(),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        DatePicker::make('birthday')
                                            ->label(__('Дата народження'))
                                            ->nullable()
                                            ->maxDate(now()),

                                        TextInput::make('location')
                                            ->label(__('Місцезнаходження'))
                                            ->maxLength(100)
                                            ->nullable(),
                                    ]),

                                TextInput::make('password')
                                    ->label(__('Пароль'))
                                    ->password()
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->minLength(8)
                                    ->maxLength(255),

                                Textarea::make('bio')
                                    ->label(__('Біографія'))
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make(__('Медіа та соціальні мережі'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\FileUpload::make('profile_picture')
                                            ->label(__('Фото профілю'))
                                            ->image()
                                            ->directory('user-profiles')
                                            ->maxSize(2048)
                                            ->nullable(),

                                        Forms\Components\KeyValue::make('social_media_links')
                                            ->label(__('Соціальні мережі'))
                                            ->keyLabel(__('Платформа'))
                                            ->valueLabel(__('URL'))
                                            ->nullable(),
                                    ]),
                            ]),

                        Tab::make(__('Налаштування'))
                            ->schema([
                                Section::make(__('Профіль'))
                                    ->schema([
                                        Toggle::make('is_public')
                                            ->label(__('Публічний профіль'))
                                            ->default(true),
                                    ]),

                                Section::make(__('Активність'))
                                    ->schema([
                                        DateTimePicker::make('last_login')
                                            ->label(__('Останній вхід'))
                                            ->nullable()
                                            ->disabled(),

                                        DateTimePicker::make('email_verified_at')
                                            ->label(__('Дата верифікації email'))
                                            ->nullable()
                                            ->disabled(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('profile_picture')
                    ->label(__('Фото'))
                    ->circular(),

                TextColumn::make('username')
                    ->label(__('Ім\'я користувача'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->label(__('Роль'))
                    ->badge()
                    ->color(fn (Role $state): string => $state->getColor())
                    ->icon(fn (Role $state): string => $state->getIcon())
                    ->sortable(),

                TextColumn::make('gender')
                    ->label(__('Стать'))
                    ->badge()
                    ->color(fn (?Gender $state): ?string => $state?->getColor())
                    ->formatStateUsing(fn (?Gender $state): ?string => $state?->getLabel())
                    ->sortable(),

                TextColumn::make('birthday')
                    ->label(__('Дата народження'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('location')
                    ->label(__('Місцезнаходження'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('last_login')
                    ->label(__('Останній вхід'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('shelves_count')
                    ->label(__('Кількість полиць'))
                    ->counts('shelves')
                    ->sortable(),

                TextColumn::make('ratings_count')
                    ->label(__('Кількість рейтингів'))
                    ->counts('ratings')
                    ->sortable(),

                TextColumn::make('comments_count')
                    ->label(__('Кількість коментарів'))
                    ->counts('comments')
                    ->sortable(),

                TextColumn::make('groups_count')
                    ->label(__('Кількість груп'))
                    ->counts('groups')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label(__('Роль'))
                    ->options(Role::class)
                    ->multiple()
                    ->indicator(__('Роль')),

                SelectFilter::make('gender')
                    ->label(__('Стать'))
                    ->options(Gender::class)
                    ->multiple()
                    ->indicator(__('Стать')),

                TernaryFilter::make('is_public')
                    ->label(__('Публічність профілю'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Публічні'))
                    ->falseLabel(__('Приватні'))
                    ->indicator(__('Публічність')),

                Filter::make('last_login')
                    ->label(__('Останній вхід'))
                    ->form([
                        DatePicker::make('last_login_from')
                            ->label(__('Від')),
                        DatePicker::make('last_login_until')
                            ->label(__('До')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['last_login_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('last_login', '>=', $date),
                            )
                            ->when(
                                $data['last_login_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('last_login', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['last_login_from'] ?? null) {
                            $indicators[] = __('Останній вхід від') . ' ' . Carbon::parse($data['last_login_from'])->toFormattedDateString();
                        }
                        if ($data['last_login_until'] ?? null) {
                            $indicators[] = __('Останній вхід до') . ' ' . Carbon::parse($data['last_login_until'])->toFormattedDateString();
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('reset_password')
                    ->label(__('Скинути пароль'))
                    ->form([
                        TextInput::make('new_password')
                            ->label(__('Новий пароль'))
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->maxLength(255),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->update(['password' => bcrypt($data['new_password'])]);
                    })
                    ->requiresConfirmation()
                    ->visible(fn (?Model $record) => auth()->check() && auth()->user()->role === Role::ADMIN),
            ])
            ->bulkActions([
                BulkActionGroup::make([]),
            ])
            ->defaultSort('created_at', 'desc')
            ->groups([
                'role',
                'gender',
                'is_public',
            ]);
    }
    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
            GroupsRelationManager::class,
            QuotesRelationManager::class,
            RatingsRelationManager::class,
            ShelvesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }



}
