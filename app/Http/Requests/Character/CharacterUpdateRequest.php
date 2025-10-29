<?php

namespace App\Http\Requests\Character;

use Illuminate\Foundation\Http\FormRequest;

class CharacterUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('character')) ?? false;
    }

    public function rules(): array
    {
        return [
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
            'name' => [
                'description' => 'Оновлене ім\'я персонажа.',
                'example' => 'Гаррі Поттер',
            ],
            'other_names' => [
                'description' => 'Оновлені інші імена персонажа.',
                'example' => '["Хлопчик, який вижив"]',
            ],
            'race' => [
                'description' => 'Оновлена раса персонажа.',
                'example' => 'Чарівник',
            ],
            'nationality' => [
                'description' => 'Оновлена національність.',
                'example' => 'British',
            ],
            'residence' => [
                'description' => 'Оновлене місце проживання.',
                'example' => 'Hogwarts',
            ],
            'biography' => [
                'description' => 'Оновлена біографія.',
                'example' => 'Головний герой серії...',
            ],
            'fun_facts' => [
                'description' => 'Оновлені цікаві факти.',
                'example' => '["Має шрам у формі блискавки"]',
            ],
            'links' => [
                'description' => 'Оновлені посилання.',
                'example' => '["https://harrypotter.fandom.com"]',
            ],
            'media_images' => [
                'description' => 'Оновлені URL зображень.',
                'example' => '["https://example.com/image.jpg"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'character' => [
                'description' => 'UUID персонажа.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
