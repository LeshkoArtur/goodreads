<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum JoinPolicy: string implements HasColor, HasIcon, HasLabel
{
    case OPEN = 'open';
    case REQUEST = 'request';
    case INVITE_ONLY = 'invite_only';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('join_policy.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::OPEN => 'success',     // Green for open
            self::REQUEST => 'warning',  // Yellow for request
            self::INVITE_ONLY => 'gray', // Gray for invite_only
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::OPEN => 'heroicon-o-lock-open',
            self::REQUEST => 'heroicon-o-clipboard-document-check',
            self::INVITE_ONLY => 'heroicon-o-lock-closed',
        };
    }
}
