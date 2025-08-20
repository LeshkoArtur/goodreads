<?php

namespace App\Http\Requests\Character;

use App\Models\Character;
use Illuminate\Foundation\Http\FormRequest;

class CharacterIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Character::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'race' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'residence' => ['nullable', 'string', 'max:255'],
            'other_names' => ['nullable', 'json'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для імені, опису або біографії персонажа.',
                'example' => 'Герой фентезі',
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
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'race' => [
                'description' => 'Фільтр за расою персонажа.',
                'example' => 'Ельф',
            ],
            'nationality' => [
                'description' => 'Фільтр за національністю персонажа.',
                'example' => 'Гондорець',
            ],
            'residence' => [
                'description' => 'Фільтр за місцем проживання персонажа.',
                'example' => 'Шир',
            ],
            'other_names' => [
                'description' => 'Фільтр за іншими іменами персонажа (JSON масив).',
                'example' => '["Більбо", "Беггінс"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
