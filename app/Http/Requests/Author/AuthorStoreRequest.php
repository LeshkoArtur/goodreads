<?php

namespace App\Http\Requests\Author;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Author::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url'],
            'profile_picture' => ['nullable', 'url'],
            'death_date' => ['nullable', 'date', 'after_or_equal:birth_date'],
            'social_media_links' => ['nullable', 'json'],
            'media_images' => ['nullable', 'json'],
            'media_videos' => ['nullable', 'json'],
            'fun_facts' => ['nullable', 'json'],
            'type_of_work' => ['nullable', Rule::in(\App\Enums\TypeOfWork::values())],
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
            'bio' => [
                'description' => 'Біографія автора.',
                'example' => 'Джейн Доу - відома романістка...',
            ],
            'birth_date' => [
                'description' => 'Дата народження у форматі Y-m-d.',
                'example' => '1970-05-15',
            ],
            'birth_place' => [
                'description' => 'Місце народження автора.',
                'example' => 'Нью-Йорк',
            ],
            'nationality' => [
                'description' => 'Національність автора.',
                'example' => 'Американець',
            ],
            'website' => [
                'description' => 'Вебсайт автора.',
                'example' => 'https://janedoe.com',
            ],
            'profile_picture' => [
                'description' => 'URL фото профілю автора.',
                'example' => 'https://example.com/profile.jpg',
            ],
            'death_date' => [
                'description' => 'Дата смерті у форматі Y-m-d.',
                'example' => '2020-01-01',
            ],
            'social_media_links' => [
                'description' => 'Посилання на соціальні мережі (JSON масив).',
                'example' => '["https://twitter.com/author", "https://facebook.com/author"]',
            ],
            'media_images' => [
                'description' => 'Фото автора (JSON масив).',
                'example' => '["https://example.com/image1.jpg", "https://example.com/image2.jpg"]',
            ],
            'media_videos' => [
                'description' => 'Відео автора (JSON масив).',
                'example' => '["https://youtube.com/video1", "https://youtube.com/video2"]',
            ],
            'fun_facts' => [
                'description' => 'Цікаві факти про автора (JSON масив).',
                'example' => '["Факт 1", "Факт 2"]',
            ],
            'type_of_work' => [
                'description' => 'Тип роботи автора.',
                'example' => 'Романіст',
            ],
            'user_ids' => [
                'description' => 'Масив ID користувачів (JSON).',
                'example' => '["user-uuid1", "user-uuid2"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
