<?php

namespace App\Http\Requests\Book;

use App\Enums\AgeRestriction;
use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $book = $this->route('book');
        return $this->user()->can('update', $book);
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'plot' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'series_id' => ['nullable', 'string', 'exists:book_series,id'],
            'number_in_series' => ['nullable', 'integer', 'min:1'],
            'page_count' => ['nullable', 'integer', 'min:1'],
            'languages' => ['nullable', 'json'],
            'cover_image' => ['nullable', 'url'],
            'fun_facts' => ['nullable', 'json'],
            'adaptations' => ['nullable', 'json'],
            'is_bestseller' => ['nullable', 'boolean'],
            'average_rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'age_restriction' => ['nullable', Rule::in(AgeRestriction::values())],
            'author_ids' => ['nullable', 'json'],
            'genre_ids' => ['nullable', 'json'],
            'publisher_ids' => ['nullable', 'json'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва книги.',
                'example' => 'Гобіт',
            ],
            'description' => [
                'description' => 'Опис книги.',
                'example' => 'Фентезійний роман про Більбо Беггінса.',
            ],
            'plot' => [
                'description' => 'Сюжет книги.',
                'example' => 'Більбо вирушає у пригоду...',
            ],
            'history' => [
                'description' => 'Історія створення книги.',
                'example' => 'Написано під час...',
            ],
            'series_id' => [
                'description' => 'ID серії книг.',
                'example' => 'series-uuid123',
            ],
            'number_in_series' => [
                'description' => 'Номер книги в серії.',
                'example' => 1,
            ],
            'page_count' => [
                'description' => 'Кількість сторінок у книзі.',
                'example' => 300,
            ],
            'languages' => [
                'description' => 'Мови, якими доступна книга (JSON масив).',
                'example' => '["Англійська", "Іспанська"]',
            ],
            'cover_image' => [
                'description' => 'URL обкладинки книги.',
                'example' => 'https://example.com/cover.jpg',
            ],
            'fun_facts' => [
                'description' => 'Цікаві факти про книгу (JSON масив).',
                'example' => '["Факт 1", "Факт 2"]',
            ],
            'adaptations' => [
                'description' => 'Екранізації книги (JSON масив).',
                'example' => '["Фільм 2001", "Серіал 2010"]',
            ],
            'is_bestseller' => [
                'description' => 'Чи є книга бестселером.',
                'example' => true,
            ],
            'average_rating' => [
                'description' => 'Середній рейтинг книги.',
                'example' => 4.5,
            ],
            'age_restriction' => [
                'description' => 'Вікові обмеження для книги.',
                'example' => 'Дорослі',
            ],
            'author_ids' => [
                'description' => 'ID авторів (JSON масив).',
                'example' => '["author-uuid1", "author-uuid2"]',
            ],
            'genre_ids' => [
                'description' => 'ID жанрів (JSON масив).',
                'example' => '["genre-uuid1", "genre-uuid2"]',
            ],
            'publisher_ids' => [
                'description' => 'ID видавців із додатковими даними (JSON масив об’єктів).',
                'example' => '[{"id":"publisher-uuid1","published_date":"2020-01-01","isbn":"978-3-16-148410-0","circulation":1000,"format":"Hardcover","cover_type":"Glossy","translator":"John Smith","edition":1,"price":29.99,"binding":"Sewn"},{"id":"publisher-uuid2","published_date":"2021-06-15","isbn":"978-1-23-456789-0","circulation":500,"format":"Paperback","cover_type":"Matte","translator":null,"edition":2,"price":19.99,"binding":"Glued"}]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'book' => [
                'description' => 'ID книги для оновлення.',
                'example' => 'book-uuid123',
            ],
        ];
    }
}
