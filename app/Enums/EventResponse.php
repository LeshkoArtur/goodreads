<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EventResponse: string implements HasColor, HasIcon, HasLabel
{
    case GOING = 'going';
    case MAYBE = 'maybe';
    case NOT_GOING = 'not_going';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('event_response.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GOING => 'success',    // Green for going
            self::MAYBE => 'warning',    // Yellow for maybe
            self::NOT_GOING => 'danger', // Red for not going
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::GOING => 'heroicon-o-check-circle',
            self::MAYBE => 'heroicon-o-question-mark-circle',
            self::NOT_GOING => 'heroicon-o-x-circle',
        };
    }
}
