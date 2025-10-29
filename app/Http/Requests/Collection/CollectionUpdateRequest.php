<?php

namespace App\Http\Requests\Collection;

use Illuminate\Foundation\Http\FormRequest;

class CollectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $collection = $this->route('collection');

        return $this->user()?->can('update', $collection) ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'url', 'max:255'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва колекції.',
                'example' => 'Мої улюблені книги',
            ],
            'description' => [
                'description' => 'Опис колекції.',
                'example' => 'Оновлений опис колекції книг у жанрі фентезі.',
            ],
            'cover_image' => [
                'description' => 'URL обкладинки колекції.',
                'example' => 'https://example.com/cover.jpg',
            ],
            'is_public' => [
                'description' => 'Чи є колекція публічною.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'collection' => [
                'description' => 'ID колекції для оновлення.',
                'example' => 'collection-uuid123',
            ],
        ];
    }
}
