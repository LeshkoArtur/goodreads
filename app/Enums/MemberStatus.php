<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum MemberStatus: string implements HasColor, HasIcon, HasLabel
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case BANNED = 'banned';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('member_status.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ACTIVE => 'success',   // Green for active
            self::PENDING => 'warning',  // Yellow for pending
            self::BANNED => 'danger',    // Red for banned
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-o-check-circle',
            self::PENDING => 'heroicon-o-clock',
            self::BANNED => 'heroicon-o-x-circle',
        };
    }
}
