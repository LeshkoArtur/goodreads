<?php

namespace App\Http\Requests\Character;

use App\Models\Character;
use Illuminate\Foundation\Http\FormRequest;

class CharacterIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Character::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'book_id' => ['nullable', 'uuid', 'exists:books,id'],
            'race' => ['nullable', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:50'],
            'residence' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для імені або біографії персонажа.',
                'example' => 'Гаррі Поттер',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість персонажів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, created_at).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'book_id' => [
                'description' => 'Фільтр за UUID книги.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'race' => [
                'description' => 'Фільтр за расою персонажа.',
                'example' => 'Чарівник',
            ],
            'nationality' => [
                'description' => 'Фільтр за національністю.',
                'example' => 'British',
            ],
            'residence' => [
                'description' => 'Фільтр за місцем проживання.',
                'example' => 'Hogwarts',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
