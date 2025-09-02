<?php

namespace App\Http\Requests\Character;

use App\Models\Character;
use Illuminate\Foundation\Http\FormRequest;

class CharacterDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $character = $this->route('character');
        return $this->user()->can('delete', $character);
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'character' => [
                'description' => 'ID персонажа для видалення.',
                'example' => 'character-uuid123',
            ],
        ];
    }
}
