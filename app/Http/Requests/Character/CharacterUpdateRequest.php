<?php

namespace App\Http\Requests\Character;

use App\Models\Character;
use Illuminate\Foundation\Http\FormRequest;

class CharacterUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $character = $this->route('character');
        return $this->user()->can('update', $character);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'race' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'residence' => ['nullable', 'string', 'max:255'],
            'other_names' => ['nullable', 'json'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Ім’я персонажа.',
                'example' => 'Більбо Беггінс',
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
            'other_names' => [
                'description' => 'Інші імена персонажа (JSON масив).',
                'example' => '["Більбо", "Беггінс"]',
            ],
            'description' => [
                'description' => 'Опис персонажа.',
                'example' => 'Оновлений опис Більбо Беггінса...',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'character' => [
                'description' => 'ID персонажа для оновлення.',
                'example' => 'character-uuid123',
            ],
        ];
    }
}
