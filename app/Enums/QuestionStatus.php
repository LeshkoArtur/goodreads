<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum QuestionStatus: string implements HasColor, HasIcon, HasLabel
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case ANSWERED = 'answered';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('question_status.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'warning',   // Yellow for pending
            self::APPROVED => 'success',  // Green for approved
            self::REJECTED => 'danger',   // Red for rejected
            self::ANSWERED => 'info',     // Blue for answered
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::APPROVED => 'heroicon-o-check-circle',
            self::REJECTED => 'heroicon-o-x-circle',
            self::ANSWERED => 'heroicon-o-chat-bubble-left-right',
        };
    }
}
