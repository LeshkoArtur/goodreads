<?php

namespace App\Http\Requests\Character;

use App\Models\Character;
use Illuminate\Foundation\Http\FormRequest;

class CharacterStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Character::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'book_id' => ['required', 'uuid', 'exists:books,id'],
            'name' => ['required', 'string', 'max:255'],
            'other_names' => ['nullable', 'array'],
            'other_names.*' => ['string', 'max:255'],
            'race' => ['nullable', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:50'],
            'residence' => ['nullable', 'string', 'max:100'],
            'biography' => ['nullable', 'string'],
            'fun_facts' => ['nullable', 'array'],
            'fun_facts.*' => ['string'],
            'links' => ['nullable', 'array'],
            'links.*' => ['url'],
            'media_images' => ['nullable', 'array'],
            'media_images.*' => ['url'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'book_id' => [
                'description' => 'UUID книги, до якої належить персонаж.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'name' => [
                'description' => 'Ім\'я персонажа.',
                'example' => 'Гаррі Поттер',
            ],
            'other_names' => [
                'description' => 'Інші імена або прізвиська персонажа.',
                'example' => '["Хлопчик, який вижив", "Обраний"]',
            ],
            'race' => [
                'description' => 'Раса персонажа.',
                'example' => 'Чарівник',
            ],
            'nationality' => [
                'description' => 'Національність персонажа.',
                'example' => 'British',
            ],
            'residence' => [
                'description' => 'Місце проживання персонажа.',
                'example' => 'Hogwarts School',
            ],
            'biography' => [
                'description' => 'Біографія персонажа.',
                'example' => 'Головний герой серії книг про Гаррі Поттера...',
            ],
            'fun_facts' => [
                'description' => 'Цікаві факти про персонажа.',
                'example' => '["Має шрам у формі блискавки", "Володіє мовою змій"]',
            ],
            'links' => [
                'description' => 'Посилання на додаткову інформацію.',
                'example' => '["https://harrypotter.fandom.com/wiki/Harry_Potter"]',
            ],
            'media_images' => [
                'description' => 'URL зображень персонажа.',
                'example' => '["https://example.com/harry-potter.jpg"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
