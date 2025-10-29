<?php

namespace App\Http\Requests\Author;

use App\Enums\TypeOfWork;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $author = $this->route('author');

        return $this->user()?->can('update', $author) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'nationality' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'url', 'max:255'],
            'profile_picture' => ['nullable', 'url', 'max:255'],
            'death_date' => ['nullable', 'date', 'after_or_equal:birth_date'],
            'social_media_links' => ['nullable', 'array'],
            'social_media_links.*' => ['url', 'max:255'],
            'media_images' => ['nullable', 'array'],
            'media_images.*' => ['url', 'max:255'],
            'media_videos' => ['nullable', 'array'],
            'media_videos.*' => ['url', 'max:255'],
            'fun_facts' => ['nullable', 'array'],
            'fun_facts.*' => ['string', 'max:500'],
            'type_of_work' => ['nullable', Rule::enum(TypeOfWork::class)],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['uuid', 'exists:users,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Ім\'я автора.',
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
                'description' => 'Посилання на соціальні мережі (масив URL).',
                'example' => '["https://twitter.com/author", "https://facebook.com/author"]',
            ],
            'media_images' => [
                'description' => 'Фото автора (масив URL).',
                'example' => '["https://example.com/image1.jpg", "https://example.com/image2.jpg"]',
            ],
            'media_videos' => [
                'description' => 'Відео автора (масив URL).',
                'example' => '["https://youtube.com/video1", "https://youtube.com/video2"]',
            ],
            'fun_facts' => [
                'description' => 'Цікаві факти про автора (масив рядків).',
                'example' => '["Факт 1", "Факт 2"]',
            ],
            'type_of_work' => [
                'description' => 'Тип роботи автора (novelist, poet, playwright, тощо).',
                'example' => 'novelist',
            ],
            'user_ids' => [
                'description' => 'Масив UUID користувачів для прикріплення.',
                'example' => '["9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a", "8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b"]',
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
