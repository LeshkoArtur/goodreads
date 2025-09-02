<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Групи користувача') . ' ' . $ownerRecord->username;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('group_id')
                    ->label(__('Група'))
                    ->relationship('groups', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('pivot_role')
                    ->label(__('Роль'))
                    ->options([
                        'member' => __('Учасник'),
                        'moderator' => __('Модератор'),
                        'admin' => __('Адміністратор'),
                    ])
                    ->default('member')
                    ->required(),

                Select::make('pivot_status')
                    ->label(__('Статус'))
                    ->options([
                        'pending' => __('Очікує'),
                        'accepted' => __('Прийнято'),
                        'rejected' => __('Відхилено'),
                    ])
                    ->default('accepted')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label(__('Обкладинка'))
                    ->circular(),

                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn (Model $record): string => route('filament.admin.resources.groups.view', $record->id)),

                IconColumn::make('is_public')
                    ->label(__('Публічність'))
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-open')
                    ->falseIcon('heroicon-o-lock-closed')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('join_policy')
                    ->label(__('Політика вступу'))
                    ->badge()
                    ->formatStateUsing(fn (?JoinPolicy $state): ?string => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('post_policy')
                    ->label(__('Політика публікацій'))
                    ->badge()
                    ->formatStateUsing(fn (?PostPolicy $state): ?string => $state?->getLabel())
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pivot.role')
                    ->label(__('Роль'))
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'member' => __('Учасник'),
                        'moderator' => __('Модератор'),
                        'admin' => __('Адміністратор'),
                        default => $state,
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pivot.status')
                    ->label(__('Статус'))
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => __('Очікує'),
                        'accepted' => __('Прийнято'),
                        'rejected' => __('Відхилено'),
                        default => $state,
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pivot.joined_at')
                    ->label(__('Дата вступу'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('member_count')
                    ->label(__('Кількість учасників'))
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('join_policy')
                    ->label(__('Політика вступу'))
                    ->options(JoinPolicy::class)
                    ->multiple()
                    ->indicator(__('Політика вступу')),

                Tables\Filters\SelectFilter::make('post_policy')
                    ->label(__('Політика публікацій'))
                    ->options(PostPolicy::class)
                    ->multiple()
                    ->indicator(__('Політика публікацій')),

                Tables\Filters\SelectFilter::make('pivot_role')
                    ->label(__('Роль'))
                    ->options([
                        'member' => __('Учасник'),
                        'moderator' => __('Модератор'),
                        'admin' => __('Адміністратор'),
                    ])
                    ->multiple()
                    ->indicator(__('Роль')),

                Tables\Filters\TernaryFilter::make('is_public')
                    ->label(__('Публічність'))
                    ->placeholder(__('Всі'))
                    ->trueLabel(__('Публічні'))
                    ->falseLabel(__('Приватні'))
                    ->indicator(__('Публічність')),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('Додати до групи'))
                    ->form([
                        Select::make('group_id')
                            ->label(__('Група'))
                            ->relationship('groups', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('role')
                            ->label(__('Роль'))
                            ->options([
                                'member' => __('Учасник'),
                                'moderator' => __('Модератор'),
                                'admin' => __('Адміністратор'),
                            ])
                            ->default('member')
                            ->required(),

                        Select::make('status')
                            ->label(__('Статус'))
                            ->options([
                                'pending' => __('Очікує'),
                                'accepted' => __('Прийнято'),
                                'rejected' => __('Відхилено'),
                            ])
                            ->default('accepted')
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Редагувати'))
                    ->form([
                        Select::make('pivot_role')
                            ->label(__('Роль'))
                            ->options([
                                'member' => __('Учасник'),
                                'moderator' => __('Модератор'),
                                'admin' => __('Адміністратор'),
                            ])
                            ->required(),

                        Select::make('pivot_status')
                            ->label(__('Статус'))
                            ->options([
                                'pending' => __('Очікує'),
                                'accepted' => __('Прийнято'),
                                'rejected' => __('Відхилено'),
                            ])
                            ->required(),
                    ]),

                Tables\Actions\DetachAction::make()
                    ->label(__('Вийти з групи')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label(__('Вийти з вибраних груп')),
                ]),
            ])
            ->defaultSort('pivot.joined_at', 'desc');
    }
}
