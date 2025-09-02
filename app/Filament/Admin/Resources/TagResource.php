<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TagResource\Pages\CreateTag;
use App\Filament\Admin\Resources\TagResource\Pages\EditTag;
use App\Filament\Admin\Resources\TagResource\Pages\ListTags;
use App\Filament\Admin\Resources\TagResource\Pages\ViewTag;
use App\Filament\Admin\Resources\TagResource\RelationManagers\PostsRelationManager;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Теги';

    protected static ?int $navigationSort = 6;

    public static function getNavigationLabel(): string
    {
        return __('Теги');
    }

    public static function getModelLabel(): string
    {
        return __('Тег');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Теги');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Назва'))
                    ->required()
                    ->maxLength(50)
                    ->unique(Tag::class, 'name', ignoreRecord: true),
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

                TextColumn::make('name')
                    ->label(__('Назва'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.tags.view', $record->id)),

                TextColumn::make('posts_count')
                    ->label(__('Кількість публікацій'))
                    ->counts('posts')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Дата створення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('Дата оновлення'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label(__('Назва'))
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Назва'))
                            ->placeholder(__('Введіть назву тегу')),
                    ])
                    ->query(fn ($query, array $data) => $query->when($data['name'], fn ($q) => $q->where('name', 'like', '%' . $data['name'] . '%')))
                    ->indicateUsing(fn (array $data): array => $data['name'] ? [__('Назва') . ': ' . $data['name']] : []),
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
            ->defaultSort('name', 'asc')
            ->groups([
                'name',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'view' => ViewTag::route('/{record}'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
