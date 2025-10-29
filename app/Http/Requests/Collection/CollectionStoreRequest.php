<?php

namespace App\Http\Requests\Collection;

use App\Models\Collection;
use Illuminate\Foundation\Http\FormRequest;

class CollectionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Collection::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'url', 'max:255'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який створює колекцію.',
                'example' => 'user-uuid123',
            ],
            'title' => [
                'description' => 'Назва колекції.',
                'example' => 'Мої улюблені книги',
            ],
            'description' => [
                'description' => 'Опис колекції.',
                'example' => 'Колекція книг у жанрі фентезі.',
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
        return [];
    }
}
