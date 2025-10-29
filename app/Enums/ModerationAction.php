<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ModerationAction: string implements HasColor, HasIcon, HasLabel
{
    case DELETE = 'delete';
    case APPROVE = 'approve';
    case REJECT = 'reject';
    case WARNING = 'warning';
    case BAN = 'ban';
    case UNBAN = 'unban';
    case PIN = 'pin';
    case UNPIN = 'unpin';
    case EDIT = 'edit';
    case MOVE = 'move';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DELETE => 'Видалення',
            self::APPROVE => 'Схвалення',
            self::REJECT => 'Відхилення',
            self::WARNING => 'Попередження',
            self::BAN => 'Бан користувача',
            self::UNBAN => 'Розбан користувача',
            self::PIN => 'Закріплення',
            self::UNPIN => 'Відкріплення',
            self::EDIT => 'Редагування',
            self::MOVE => 'Переміщення',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DELETE => 'danger',
            self::APPROVE => 'success',
            self::REJECT => 'warning',
            self::WARNING => 'warning',
            self::BAN => 'danger',
            self::UNBAN => 'success',
            self::PIN => 'info',
            self::UNPIN => 'gray',
            self::EDIT => 'primary',
            self::MOVE => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DELETE => 'heroicon-o-trash',
            self::APPROVE => 'heroicon-o-check-circle',
            self::REJECT => 'heroicon-o-x-circle',
            self::WARNING => 'heroicon-o-exclamation-triangle',
            self::BAN => 'heroicon-o-no-symbol',
            self::UNBAN => 'heroicon-o-lock-open',
            self::PIN => 'heroicon-o-bookmark',
            self::UNPIN => 'heroicon-o-bookmark-slash',
            self::EDIT => 'heroicon-o-pencil',
            self::MOVE => 'heroicon-o-arrow-right-circle',
        };
    }
}
