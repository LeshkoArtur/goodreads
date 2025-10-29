<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Currency: string implements HasColor, HasIcon, HasLabel
{
    case USD = 'USD';
    case EUR = 'EUR';
    case UAH = 'UAH';
    case GBP = 'GBP';
    case RUB = 'RUB';
    case PLN = 'PLN';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return __('currency.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::USD => 'success',
            self::EUR => 'info',
            self::UAH => 'primary',
            self::GBP => 'gray',
            self::RUB => 'danger',
            self::PLN => 'warning',
            self::OTHER => 'secondary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::USD => 'heroicon-o-currency-dollar',
            self::EUR => 'heroicon-o-globe',
            self::UAH => 'heroicon-o-currency-euro',
            self::GBP => 'heroicon-o-banknotes',
            self::RUB => 'heroicon-o-fire',
            self::PLN => 'heroicon-o-cash',
            self::OTHER => 'heroicon-o-question-mark-circle',
        };
    }
}
