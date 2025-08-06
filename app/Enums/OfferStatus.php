<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OfferStatus: string implements HasColor, HasIcon, HasLabel
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case INACTIVE = 'inactive';
    case REJECTED = 'rejected';

    public function getLabel(): ?string
    {
        return __('offer_status.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::PENDING => 'warning',
            self::INACTIVE => 'gray',
            self::REJECTED => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-o-check-circle',
            self::PENDING => 'heroicon-o-clock',
            self::INACTIVE => 'heroicon-o-x-circle',
            self::REJECTED => 'heroicon-o-ban',
        };
    }
}
