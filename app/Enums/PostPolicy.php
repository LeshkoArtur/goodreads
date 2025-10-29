<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PostPolicy: string implements HasColor, HasIcon, HasLabel
{
    case ALL = 'all';
    case MODERATORS = 'moderators';
    case ADMINS = 'admins';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('post_policy.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ALL => 'success',      // Green for all
            self::MODERATORS => 'warning', // Yellow for moderators
            self::ADMINS => 'gray',      // Gray for admins
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::ALL => 'heroicon-o-users',
            self::MODERATORS => 'heroicon-o-shield-check',
            self::ADMINS => 'heroicon-o-key',
        };
    }
}
