<?php

namespace App\Http\Requests\ReadingStat;

use Illuminate\Foundation\Http\FormRequest;

class ReadingStatDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $readingStat = $this->route('reading_stat');

        return $this->user()?->can('delete', $readingStat) ?? false;
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
            'reading_stat' => [
                'description' => 'ID статистики читання для видалення.',
                'example' => 'reading-stat-uuid123',
            ],
        ];
    }
}
