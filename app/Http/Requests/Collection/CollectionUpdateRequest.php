<?php

namespace App\Http\Requests\Collection;

use App\Models\Collection;
use Illuminate\Foundation\Http\FormRequest;

class CollectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $collection = $this->route('collection');
        return $this->user()->can('update', $collection);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'is_public' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва колекції.',
                'example' => 'Мої улюблені книги',
            ],
            'is_public' => [
                'description' => 'Чи є колекція публічною.',
                'example' => true,
            ],
            'description' => [
                'description' => 'Опис колекції.',
                'example' => 'Оновлений опис колекції книг у жанрі фентезі.',
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
