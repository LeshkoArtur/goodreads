<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Post::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'author_id' => ['nullable', 'string', 'exists:authors,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['string', 'exists:tags,id'],
            'type' => ['nullable', Rule::in(\App\Enums\PostType::values())],
            'status' => ['nullable', Rule::in(\App\Enums\PostStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який створює пост.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'ID книги, до якої відноситься пост.',
                'example' => 'book-uuid123',
            ],
            'author_id' => [
                'description' => 'ID автора, до якого відноситься пост.',
                'example' => 'author-uuid123',
            ],
            'title' => [
                'description' => 'Заголовок поста.',
                'example' => 'Огляд нової книги',
            ],
            'content' => [
                'description' => 'Текст поста.',
                'example' => 'Це мій огляд на нову книгу...',
            ],
            'cover_image' => [
                'description' => 'URL або шлях до обкладинки поста.',
                'example' => '/images/cover.jpg',
            ],
            'published_at' => [
                'description' => 'Дата публікації поста у форматі Y-m-d H:i:s.',
                'example' => '2023-01-01 12:00:00',
            ],
            'tag_ids' => [
                'description' => 'Масив ID тегів, пов’язаних з постом.',
                'example' => ['tag-uuid123', 'tag-uuid456'],
            ],
            'type' => [
                'description' => 'Тип поста.',
                'example' => 'ARTICLE',
            ],
            'status' => [
                'description' => 'Статус поста.',
                'example' => 'PUBLISHED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
