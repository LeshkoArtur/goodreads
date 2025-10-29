<?php

namespace App\Filament\Admin\Resources;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use App\Filament\Admin\Resources\GroupResource\Pages;
use App\Models\Group;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Функціонал груп';

    protected static ?int $navigationSort = 21;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'Група';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Групи';
    }

    public static function getNavigationLabel(): string
    {
        return 'Групи';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'creator.username'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Створив' => $record->creator->username,
            'Учасників' => $record->member_count ?? 0,
            'Статус' => $record->is_active ? 'Активна' : 'Неактивна',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['members', 'posts', 'events']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Назва та опис групи')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва групи')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        FileUpload::make('cover_image')
                            ->label('Обкладинка')
                            ->image()
                            ->disk('public')
                            ->directory('groups')
                            ->imageEditor()
                            ->columnSpan(1),
                        Select::make('creator_id')
                            ->label('Створив')
                            ->relationship('creator', 'username')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Textarea::make('description')
                            ->label('Опис')
                            ->rows(4)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Налаштування')
                    ->description('Параметри доступу та публікації')
                    ->schema([
                        Toggle::make('is_public')
                            ->label('Публічна група')
                            ->default(false)
                            ->helperText('Публічна група видима всім користувачам'),
                        Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true)
                            ->helperText('Неактивні групи приховані'),
                        Select::make('join_policy')
                            ->label('Політика приєднання')
                            ->options(JoinPolicy::class)
                            ->native(false)
                            ->default(JoinPolicy::OPEN)
                            ->required(),
                        Select::make('post_policy')
                            ->label('Хто може публікувати')
                            ->options(PostPolicy::class)
                            ->native(false)
                            ->default(PostPolicy::ALL)
                            ->required(),
                    ])
                    ->columns(4),

                Section::make('Правила групи')
                    ->schema([
                        RichEditor::make('rules')
                            ->label('Правила')
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList'])
                            ->columnSpanFull(),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->disk('public')
                    ->size(50)
                    ->circular(),
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('creator.username')
                    ->label('Створив')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_public')
                    ->label('Публічна')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('join_policy')
                    ->label('Приєднання')
                    ->badge()
                    ->color(fn (?JoinPolicy $state): string|array|null => $state?->getColor())
                    ->toggleable(),
                TextColumn::make('post_policy')
                    ->label('Постинг')
                    ->badge()
                    ->color(fn (?PostPolicy $state): string|array|null => $state?->getColor())
                    ->toggleable(),
                TextColumn::make('member_count')
                    ->label('Учасників')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->default(0),
                TextColumn::make('posts_count')
                    ->label('Постів')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_public')
                    ->label('Публічна група'),
                TernaryFilter::make('is_active')
                    ->label('Активна'),
                SelectFilter::make('join_policy')
                    ->label('Політика приєднання')
                    ->options(JoinPolicy::class)
                    ->native(false),
                SelectFilter::make('post_policy')
                    ->label('Політика постів')
                    ->options(PostPolicy::class)
                    ->native(false),
                SelectFilter::make('creator')
                    ->label('Створив')
                    ->relationship('creator', 'username')
                    ->searchable()
                    ->preload(),
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
            ->defaultSort('member_count', 'desc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            GroupResource\RelationManagers\MembersRelationManager::class,
            GroupResource\RelationManagers\GroupPostsRelationManager::class,
            GroupResource\RelationManagers\GroupEventsRelationManager::class,
            GroupResource\RelationManagers\GroupInvitationsRelationManager::class,
            GroupResource\RelationManagers\GroupPollsRelationManager::class,
            GroupResource\RelationManagers\ModerationLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'view' => Pages\ViewGroup::route('/{record}'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
