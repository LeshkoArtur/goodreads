<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CoverType: string implements HasColor, HasIcon, HasLabel
{
    case HARDCOVER = 'hardcover';
    case PAPERBACK = 'paperback';
    case OTHER = 'other';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('cover_type.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::HARDCOVER => 'primary',  // Blue for hardcover
            self::PAPERBACK => 'success',  // Green for paperback
            self::OTHER => 'gray',         // Gray for other
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::HARDCOVER => 'heroicon-o-book-open',
            self::PAPERBACK => 'heroicon-o-document',
            self::OTHER => 'heroicon-o-ellipsis-horizontal',
        };
    }
}
