<?php

namespace App\Enums;

enum TaggableType: string
{
    case POST = 'post';

    public function getModelClass(): string
    {
        return match ($this) {
            self::POST => \App\Models\Post::class,
        };
    }
}
