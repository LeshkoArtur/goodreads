<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PostCategory: string implements HasColor, HasIcon, HasLabel
{
    case GENERAL = 'general';
    case SPOILERS = 'spoilers';
    case RECOMMENDATIONS = 'recommendations';
    case OFF_TOPIC = 'off_topic';
    case OTHER = 'other';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('post_category.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GENERAL => 'primary',      // Blue for general
            self::SPOILERS => 'warning',     // Yellow for spoilers
            self::RECOMMENDATIONS => 'success', // Green for recommendations
            self::OFF_TOPIC => 'danger',     // Red for off-topic
            self::OTHER => 'gray',           // Gray for other
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::GENERAL => 'heroicon-o-chat-bubble-left-right',
            self::SPOILERS => 'heroicon-o-eye-slash',
            self::RECOMMENDATIONS => 'heroicon-o-hand-thumb-up',
            self::OFF_TOPIC => 'heroicon-o-exclamation-circle',
            self::OTHER => 'heroicon-o-ellipsis-horizontal',
        };
    }
}
