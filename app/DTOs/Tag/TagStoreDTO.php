<?php

namespace App\DTOs\Tag;

use Illuminate\Http\Request;

class TagStoreDTO
{
    /**
     * @param string $name Назва тегу
     */
    public function __construct(
        public readonly string $name
    ) {}

    /**
     * Створити TagStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name')
        );
    }
}
