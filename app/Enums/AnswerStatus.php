<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AnswerStatus: string implements HasColor, HasIcon, HasLabel
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('answer_status.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DRAFT => 'gray',       // Gray for draft
            self::PENDING => 'warning',  // Yellow for pending
            self::PUBLISHED => 'success', // Green for published
            self::REJECTED => 'danger',  // Red for rejected
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::DRAFT => 'heroicon-o-pencil',
            self::PENDING => 'heroicon-o-clock',
            self::PUBLISHED => 'heroicon-o-check-circle',
            self::REJECTED => 'heroicon-o-x-circle',
        };
    }
}
