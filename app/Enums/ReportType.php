<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ReportType: string implements HasColor, HasIcon, HasLabel
{
    case SPAM = 'spam';
    case OFFENSIVE = 'offensive';
    case INAPPROPRIATE = 'inappropriate';
    case SPOILERS = 'spoilers';
    case COPYRIGHT = 'copyright';
    case OTHER = 'other';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('report_type.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SPAM => 'warning',       // Yellow for spam
            self::OFFENSIVE => 'danger',   // Red for offensive
            self::INAPPROPRIATE => 'danger', // Red for inappropriate
            self::SPOILERS => 'info',      // Blue for spoilers
            self::COPYRIGHT => 'primary',  // Primary for copyright
            self::OTHER => 'gray',         // Gray for other
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::SPAM => 'heroicon-o-exclamation-circle',
            self::OFFENSIVE => 'heroicon-o-x-circle',
            self::INAPPROPRIATE => 'heroicon-o-shield-exclamation',
            self::SPOILERS => 'heroicon-o-eye-slash',
            self::COPYRIGHT => 'heroicon-o-document-text',
            self::OTHER => 'heroicon-o-ellipsis-horizontal',
        };
    }
}
