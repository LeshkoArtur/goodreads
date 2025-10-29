<?php

namespace App\Http\Requests\Rating;

use App\Models\Rating;
use Illuminate\Foundation\Http\FormRequest;

class RatingIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Rating::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:rating,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'book_id' => ['nullable', 'uuid', 'exists:books,id'],
            'min_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'max_rating' => ['nullable', 'integer', 'min:1', 'max:5', 'gte:min_rating'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для відгуку рейтингу.',
                'example' => 'Чудова книга',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість рейтингів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (rating, created_at).',
                'example' => 'rating',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача, який залишив рейтинг.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'min_rating' => [
                'description' => 'Мінімальний бал рейтингу для фільтрації.',
                'example' => 1,
            ],
            'max_rating' => [
                'description' => 'Максимальний бал рейтингу для фільтрації.',
                'example' => 5,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
