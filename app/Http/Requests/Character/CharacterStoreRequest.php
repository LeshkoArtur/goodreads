<?php

namespace App\Http\Requests\Character;

use App\Models\Character;
use Illuminate\Foundation\Http\FormRequest;

class CharacterStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Character::class);
    }

    public function rules(): array
    {
        return [
            'book_id' => ['required', 'string', 'exists:books,id'],
            'name' => ['required', 'string', 'max:255'],
            'other_names' => ['nullable', 'json'],
            'race' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'residence' => ['nullable', 'string', 'max:255'],
            'biography' => ['nullable', 'string'],
            'fun_facts' => ['nullable', 'json'],
            'links' => ['nullable', 'json'],
            'media_images' => ['nullable', 'json'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'book_id' => [
                'description' => 'ID книги, до якої відноситься персонаж.',
                'example' => 'book-uuid123',
            ],
            'name' => [
                'description' => 'Ім’я персонажа.',
                'example' => 'Більбо Беггінс',
            ],
            'other_names' => [
                'description' => 'Інші імена персонажа (JSON масив).',
                'example' => '["Більбо", "Беггінс"]',
            ],
            'race' => [
                'description' => 'Раса персонажа.',
                'example' => 'Гобіт',
            ],
            'nationality' => [
                'description' => 'Національність персонажа.',
                'example' => 'Ширський',
            ],
            'residence' => [
                'description' => 'Місце проживання персонажа.',
                'example' => 'Шир',
            ],
            'biography' => [
                'description' => 'Біографія персонажа.',
                'example' => 'Більбо Беггінс — гобіт із Ширу, відомий своєю пригодою...',
            ],
            'fun_facts' => [
                'description' => 'Цікаві факти про персонажа (JSON масив).',
                'example' => '["Любить їсти другу сніданок", "Має магічний перстень"]',
            ],
            'links' => [
                'description' => 'Посилання, пов’язані з персонажем (JSON масив).',
                'example' => '["https://wiki.example.com/bilbo"]',
            ],
            'media_images' => [
                'description' => 'Зображення персонажа (JSON масив).',
                'example' => '["https://example.com/bilbo.jpg"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
