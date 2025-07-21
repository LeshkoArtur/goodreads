<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum MemberRole: string implements HasColor, HasIcon, HasLabel
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case MEMBER = 'member';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('member_role.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ADMIN => 'primary',     // Blue for admin
            self::MODERATOR => 'warning', // Yellow for moderator
            self::MEMBER => 'success',    // Green for member
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::ADMIN => 'heroicon-o-key',
            self::MODERATOR => 'heroicon-o-shield-check',
            self::MEMBER => 'heroicon-o-user',
        };
    }
}
