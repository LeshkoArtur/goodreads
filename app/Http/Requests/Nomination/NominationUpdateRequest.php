<?php

namespace App\Http\Requests\Nomination;

use App\Models\Nomination;
use Illuminate\Foundation\Http\FormRequest;

class NominationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $nomination = $this->route('nomination');
        return $this->user()->can('update', $nomination);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва номінації.',
                'example' => 'Найкраща книга року',
            ],
            'description' => [
                'description' => 'Опис номінації.',
                'example' => 'Оновлений опис для номінації найкращих книг.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'nomination' => [
                'description' => 'ID номінації для оновлення.',
                'example' => 'nomination-uuid123',
            ],
        ];
    }
}
