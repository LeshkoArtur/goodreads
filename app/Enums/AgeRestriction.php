<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AgeRestriction: string implements HasColor, HasIcon, HasLabel
{
    case NONE = '0+';
    case SIX_PLUS = '6+';
    case TWELVE_PLUS = '12+';
    case SIXTEEN_PLUS = '16+';
    case EIGHTEEN_PLUS = '18+';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('age_restriction.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NONE => 'success',      // Green for no restriction
            self::SIX_PLUS => 'info',     // Blue for 6+
            self::TWELVE_PLUS => 'warning', // Yellow for 12+
            self::SIXTEEN_PLUS => 'danger', // Red for 16+
            self::EIGHTEEN_PLUS => 'gray',  // Gray for 18+
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::NONE => 'heroicon-o-check-circle',
            self::SIX_PLUS => 'heroicon-o-user',
            self::TWELVE_PLUS => 'heroicon-o-users',
            self::SIXTEEN_PLUS => 'heroicon-o-shield-exclamation',
            self::EIGHTEEN_PLUS => 'heroicon-o-lock-closed',
        };
    }
}
