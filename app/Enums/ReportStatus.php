<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ReportStatus: string implements HasColor, HasIcon, HasLabel
{
    case PENDING = 'pending';
    case REVIEWED = 'reviewed';
    case RESOLVED = 'resolved';
    case DISMISSED = 'dismissed';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('report_status.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'warning',    // Yellow for pending
            self::REVIEWED => 'info',      // Blue for reviewed
            self::RESOLVED => 'success',   // Green for resolved
            self::DISMISSED => 'gray',     // Gray for dismissed
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::REVIEWED => 'heroicon-o-eye',
            self::RESOLVED => 'heroicon-o-check-circle',
            self::DISMISSED => 'heroicon-o-x-circle',
        };
    }
}
