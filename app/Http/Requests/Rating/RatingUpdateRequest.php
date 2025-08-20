<?php

namespace App\Http\Requests\Rating;

use App\Models\Rating;
use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $rating = $this->route('rating');
        return $this->user()->can('update', $rating);
    }

    public function rules(): array
    {
        return [
            'score' => ['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'score' => [
                'description' => 'Оновлений бал рейтингу (від 1 до 5).',
                'example' => 4,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'rating' => [
                'description' => 'ID рейтингу для оновлення.',
                'example' => 'rating-uuid123',
            ],
        ];
    }
}
