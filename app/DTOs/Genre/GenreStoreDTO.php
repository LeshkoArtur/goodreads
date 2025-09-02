<?php

namespace App\DTOs\Genre;

use Illuminate\Http\Request;

class GenreStoreDTO
{
    /**
     * @param string $name Назва жанру
     * @param string|null $parentId ID батьківського жанру
     * @param string|null $description Опис
     * @param int|null $bookCount Кількість книг
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $parentId = null,
        public readonly ?string $description = null,
        public readonly ?int $bookCount = null
    ) {}

    /**
     * Створити GenreStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name'),
            parentId: $request->input('parent_id'),
            description: $request->input('description'),
            bookCount: $request->input('book_count')
        );
    }
}
