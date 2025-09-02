<?php

namespace App\Http\Requests\ReadingStat;

use App\Models\ReadingStat;
use Illuminate\Foundation\Http\FormRequest;

class ReadingStatUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $readingStat = $this->route('reading_stat');
        return $this->user()->can('update', $readingStat);
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', 'in:PLANNING,READING,FINISHED'],
            'pages_read' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'finish_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'status' => [
                'description' => 'Статус читання (PLANNING, READING, FINISHED).',
                'example' => 'FINISHED',
            ],
            'pages_read' => [
                'description' => 'Кількість прочитаних сторінок.',
                'example' => 300,
            ],
            'start_date' => [
                'description' => 'Дата початку читання.',
                'example' => '2023-01-01',
            ],
            'finish_date' => [
                'description' => 'Дата завершення читання.',
                'example' => '2023-06-01',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'reading_stat' => [
                'description' => 'ID статистики читання для оновлення.',
                'example' => 'reading-stat-uuid123',
            ],
        ];
    }
}
