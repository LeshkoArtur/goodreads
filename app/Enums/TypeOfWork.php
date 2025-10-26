<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TypeOfWork: string implements HasColor, HasIcon, HasLabel
{
    case NOVELIST = 'novelist';
    case SHORT_STORY_WRITER = 'short_story_writer';
    case POET = 'poet';
    case PLAYWRIGHT = 'playwright';
    case SCREENWRITER = 'screenwriter';
    case ESSAYIST = 'essayist';
    case BIOGRAPHER = 'biographer';
    case MEMOIRIST = 'memoirist';
    case HISTORIAN = 'historian';
    case JOURNALIST = 'journalist';
    case SCIENCE_WRITER = 'science_writer';
    case SELF_HELP_WRITER = 'self_help_writer';
    case CHILDREN_WRITER = 'children_writer';
    case YOUNG_ADULT_WRITER = 'young_adult_writer';
    case GRAPHIC_NOVELIST = 'graphic_novelist';
    case FANTASY_WRITER = 'fantasy_writer';
    case SCI_FI_WRITER = 'sci_fi_writer';
    case MYSTERY_WRITER = 'mystery_writer';
    case ROMANCE_WRITER = 'romance_writer';
    case HORROR_WRITER = 'horror_writer';
    case OTHER = 'other';

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('type_of_work.' . $this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NOVELIST => 'primary',
            self::SHORT_STORY_WRITER => 'success',
            self::POET => 'info',
            self::PLAYWRIGHT => 'warning',
            self::SCREENWRITER => 'danger',
            self::ESSAYIST => 'gray',
            self::BIOGRAPHER => 'success',
            self::MEMOIRIST => 'info',
            self::HISTORIAN => 'primary',
            self::JOURNALIST => 'warning',
            self::SCIENCE_WRITER => 'info',
            self::SELF_HELP_WRITER => 'success',
            self::CHILDREN_WRITER => 'primary',
            self::YOUNG_ADULT_WRITER => 'warning',
            self::GRAPHIC_NOVELIST => 'danger',
            self::FANTASY_WRITER => 'info',
            self::SCI_FI_WRITER => 'primary',
            self::MYSTERY_WRITER => 'gray',
            self::ROMANCE_WRITER => 'success',
            self::HORROR_WRITER => 'danger',
            self::OTHER => 'gray',
        };
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        return match ($this) {
            self::NOVELIST => 'heroicon-o-book-open',
            self::SHORT_STORY_WRITER => 'heroicon-o-document-text',
            self::POET => 'heroicon-o-pencil-alt',
            self::PLAYWRIGHT => 'heroicon-o-globe-alt',
            self::SCREENWRITER => 'heroicon-o-film',
            self::ESSAYIST => 'heroicon-o-document-report',
            self::BIOGRAPHER => 'heroicon-o-user-group',
            self::MEMOIRIST => 'heroicon-o-heart',
            self::HISTORIAN => 'heroicon-o-clock',
            self::JOURNALIST => 'heroicon-o-newspaper',
            self::SCIENCE_WRITER => 'heroicon-o-beaker',
            self::SELF_HELP_WRITER => 'heroicon-o-light-bulb',
            self::CHILDREN_WRITER => 'heroicon-o-user',
            self::YOUNG_ADULT_WRITER => 'heroicon-o-users',
            self::GRAPHIC_NOVELIST => 'heroicon-o-photograph',
            self::FANTASY_WRITER => 'heroicon-o-sparkles',
            self::SCI_FI_WRITER => 'heroicon-o-star',
            self::MYSTERY_WRITER => 'heroicon-o-question-mark-circle',
            self::ROMANCE_WRITER => 'heroicon-o-heart',
            self::HORROR_WRITER => 'heroicon-o-fire',
            self::OTHER => 'heroicon-o-dots-horizontal',
        };
    }
}
