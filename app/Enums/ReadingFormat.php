<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ReadingFormat: string implements HasColor, HasIcon, HasLabel
{
    case PHYSICAL = 'physical';
    case EBOOK = 'ebook';
    case AUDIOBOOK = 'audiobook';
    case OTHER = 'other';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('reading_format.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PHYSICAL => 'primary',   // Blue for physical books
            self::EBOOK => 'success',      // Green for ebooks
            self::AUDIOBOOK => 'info',     // Light blue for audiobooks
            self::OTHER => 'gray',         // Gray for other formats
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::PHYSICAL => 'heroicon-o-book-open',
            self::EBOOK => 'heroicon-o-device-tablet',
            self::AUDIOBOOK => 'heroicon-o-speaker-wave',
            self::OTHER => 'heroicon-o-dots-horizontal',
        };
    }
}
