<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GroupResource\Pages\CreateGroup;
use App\Filament\Admin\Resources\GroupResource\Pages\EditGroup;
use App\Filament\Admin\Resources\GroupResource\Pages\ListGroups;
use App\Filament\Admin\Resources\GroupResource\Pages\ViewGroup;
use App\Filament\Admin\Resources\GroupResource\RelationManagers\GroupPostsRelationManager;
use App\Filament\Admin\Resources\GroupResource\RelationManagers\GroupEventsRelationManager;
use App\Filament\Admin\Resources\GroupResource\RelationManagers\GroupInvitationsRelationManager;
use App\Filament\Admin\Resources\GroupResource\RelationManagers\GroupPollsRelationManager;
use App\Filament\Admin\Resources\GroupResource\RelationManagers\GroupModerationLogsRelationManager;
use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Групи';

    protected static ?int $navigationSort = 10;

    public static function getNavigationLabel(): string
    {
        return __('Групи');
    }

    public static function getModelLabel(): string
    {
        return __('Група');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Групи');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Назва'))
                    ->required()
                    ->maxLength(255)
                    ->unique(Group::class, 'name', ignoreRecord: true),

                Textarea::make('description')
                    ->label(__('Опис'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                Select::make('creator_id')
                    ->label(__('Творець'))
                    ->relationship('creator', 'username')
                    ->required()
                    ->searchable()
                    ->preload(),

                Toggle::make('is_public')
                    ->label(__('Публічна група'))
                    ->default(true),

                Forms\Components\FileUpload::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->directory('cover_image')
                    ->image()
                    ->maxSize(2048)
                    ->nullable(),

                Textarea::make('rules')
                    ->label(__('Правила'))
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),

                TextInput::make('member_count')
                    ->label(__('Кількість учасників'))
                    ->numeric()
                    ->minValue(0)
                    ->disabled()
                    ->dehydrated(false),

                Toggle::make('is_active')
                    ->label(__('Активна'))
                    ->default(true),

                Select::make('join_policy')
                    ->label(__('Політика приєднання'))
                    ->options(JoinPolicy::class)
                    ->required(),

                Select::make('post_policy')
                    ->label(__('Політика публікацій'))
                    ->options(PostPolicy::class)
                    ->required(),
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

                ImageColumn::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('cover_image'))
                    ->circular()
                    ->defaultImageUrl(url('path/to/default-group-image.jpg')),

                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.groups.view', $record->id)),

                TextColumn::make('creator.username')
                    ->label(__('Творець'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->creator ? route('filament.admin.resources.users.view', $record->creator_id) : null),

                TextColumn::make('member_count')
                    ->label(__('Кількість учасників'))
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_public')
                    ->label(__('Публічність'))
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-open')
                    ->falseIcon('heroicon-o-lock-closed')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label(__('Активність'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('join_policy')
                    ->label(__('Політика приєднання'))
                    ->badge()
                    ->formatStateUsing(fn (?JoinPolicy $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('post_policy')
                    ->label(__('Політика публікацій'))
                    ->badge()
                    ->formatStateUsing(fn (?PostPolicy $state) => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('posts_count')
                    ->label(__('Кількість публікацій'))
                    ->counts('posts')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('events_count')
                    ->label(__('Кількість подій'))
                    ->counts('events')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('creator_id')
                    ->label(__('Творець'))
                    ->relationship('creator', 'username')
                    ->multiple()
                    ->indicator(__('Творець')),

                TernaryFilter::make('is_public')
                    ->label(__('Публічність'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Публічні'))
                    ->falseLabel(__('Приватні'))
                    ->indicator(__('Публічність')),

                TernaryFilter::make('is_active')
                    ->label(__('Активність'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Активні'))
                    ->falseLabel(__('Неактивні'))
                    ->indicator(__('Активність')),

                SelectFilter::make('join_policy')
                    ->label(__('Політика приєднання'))
                    ->options(JoinPolicy::class)
                    ->multiple()
                    ->indicator(__('Політика приєднання')),

                SelectFilter::make('post_policy')
                    ->label(__('Політика публікацій'))
                    ->options(PostPolicy::class)
                    ->multiple()
                    ->indicator(__('Політика публікацій')),
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
            ->defaultSort('created_at', 'desc')
            ->groups([
                'creator_id',
                'is_public',
                'is_active',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            GroupPostsRelationManager::class,
            GroupEventsRelationManager::class,
            GroupInvitationsRelationManager::class,
            GroupPollsRelationManager::class,
            GroupModerationLogsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'create' => CreateGroup::route('/create'),
            'view' => ViewGroup::route('/{record}'),
            'edit' => EditGroup::route('/{record}/edit'),
        ];
    }
}
