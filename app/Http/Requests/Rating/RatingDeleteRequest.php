<?php

namespace App\Http\Requests\Rating;

use App\Models\Rating;
use Illuminate\Foundation\Http\FormRequest;

class RatingDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $rating = $this->route('rating');
        return $this->user()->can('delete', $rating);
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
            'rating' => [
                'description' => 'ID рейтингу для видалення.',
                'example' => 'rating-uuid123',
            ],
        ];
    }
}
