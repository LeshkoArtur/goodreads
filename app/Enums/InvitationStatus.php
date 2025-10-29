<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InvitationStatus: string implements HasColor, HasIcon, HasLabel
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('invitation_status.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'warning',   // Yellow for pending
            self::ACCEPTED => 'success',  // Green for accepted
            self::DECLINED => 'danger',   // Red for declined
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::ACCEPTED => 'heroicon-o-check-circle',
            self::DECLINED => 'heroicon-o-x-circle',
        };
    }
}
