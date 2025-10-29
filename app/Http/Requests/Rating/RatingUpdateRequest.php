<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $rating = $this->route('rating');

        return $this->user()?->can('update', $rating) ?? false;
    }

    public function rules(): array
    {
        return [
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'rating' => [
                'description' => 'Оновлений бал рейтингу (від 1 до 5).',
                'example' => 4,
            ],
            'review' => [
                'description' => 'Оновлений відгук до рейтингу.',
                'example' => 'Оновлений відгук про книгу.',
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
