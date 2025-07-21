<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum NominationStatus: string implements HasColor, HasIcon, HasLabel
{
    case WINNER = 'winner';
    case FINALIST = 'finalist';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('nomination_status.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::WINNER => 'success',    // Green for winners
            self::FINALIST => 'warning',  // Yellow for finalists
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::WINNER => 'heroicon-o-trophy',
            self::FINALIST => 'heroicon-o-star',
        };
    }
}
