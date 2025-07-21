<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EventStatus: string implements HasColor, HasIcon, HasLabel
{
    case UPCOMING = 'upcoming';
    case ONGOING = 'ongoing';
    case PAST = 'past';
    case CANCELED = 'canceled';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('event_status.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::UPCOMING => 'info',     // Blue for upcoming
            self::ONGOING => 'success',   // Green for ongoing
            self::PAST => 'gray',         // Gray for past
            self::CANCELED => 'danger',   // Red for canceled
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::UPCOMING => 'heroicon-o-calendar',
            self::ONGOING => 'heroicon-o-play',
            self::PAST => 'heroicon-o-clock',
            self::CANCELED => 'heroicon-o-x-circle',
        };
    }
}
