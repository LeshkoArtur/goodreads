<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasColor, HasIcon, HasLabel
{
    case USER = 'user';
    case AUTHOR = 'author';
    case LIBRARIAN = 'librarian';
    case ADMIN = 'admin';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('role.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::USER => 'success',     // Green for regular users
            self::AUTHOR => 'warning',   // Yellow for authors
            self::LIBRARIAN => 'info',   // Blue for librarians
            self::ADMIN => 'primary',    // Primary color for admins
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::USER => 'heroicon-o-user',
            self::AUTHOR => 'heroicon-o-pencil',
            self::LIBRARIAN => 'heroicon-o-book-open',
            self::ADMIN => 'heroicon-o-key',
        };
    }
}
