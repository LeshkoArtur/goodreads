<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PostType: string implements HasColor, HasIcon, HasLabel
{
    case ARTICLE = 'article';
    case STORY = 'story';
    case LIFEHACK = 'lifehack';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('post_type.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ARTICLE => 'primary',  // Blue for article
            self::STORY => 'info',       // Light blue for story
            self::LIFEHACK => 'success', // Green for lifehack
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::ARTICLE => 'heroicon-o-document-text',
            self::STORY => 'heroicon-o-book-open',
            self::LIFEHACK => 'heroicon-o-light-bulb',
        };
    }
}
