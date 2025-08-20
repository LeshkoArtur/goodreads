<?php

namespace App\Http\Requests\Author;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $author = $this->route('author');
        return $this->user()->can('update', $author);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'death_date' => ['nullable', 'date', 'after_or_equal:birth_date'],
            'type_of_work' => ['nullable', Rule::in(\App\Enums\TypeOfWork::values())],
            'social_media_links' => ['nullable', 'json'],
            'biography' => ['nullable', 'string'],
            'user_ids' => ['nullable', 'json'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Ім’я автора.',
                'example' => 'Джейн Доу',
            ],
            'nationality' => [
                'description' => 'Національність автора.',
                'example' => 'Американець',
            ],
            'birth_date' => [
                'description' => 'Дата народження у форматі Y-m-d.',
                'example' => '1970-05-15',
            ],
            'death_date' => [
                'description' => 'Дата смерті у форматі Y-m-d.',
                'example' => '2020-01-01',
            ],
            'type_of_work' => [
                'description' => 'Тип роботи автора.',
                'example' => 'Романіст',
            ],
            'social_media_links' => [
                'description' => 'Посилання на соціальні мережі (JSON масив).',
                'example' => '["https://twitter.com/author", "https://facebook.com/author"]',
            ],
            'biography' => [
                'description' => 'Біографія автора.',
                'example' => 'Джейн Доу - відома романістка...',
            ],
            'user_ids' => [
                'description' => 'Масив ID користувачів (JSON).',
                'example' => '["user-uuid1", "user-uuid2"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'author' => [
                'description' => 'ID автора для оновлення.',
                'example' => 'author-uuid123',
            ],
        ];
    }
}
