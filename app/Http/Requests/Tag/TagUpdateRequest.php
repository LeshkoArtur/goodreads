<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $tag = $this->route('tag');

        return $this->user()?->can('update', $tag) ?? false;
    }

    public function rules(): array
    {
        $tagId = $this->route('tag')->id;

        return [
            'name' => ['nullable', 'string', 'max:50', Rule::unique('tags', 'name')->ignore($tagId)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва тегу.',
                'example' => 'Наукова фантастика',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'tag' => [
                'description' => 'ID тегу для оновлення.',
                'example' => 'tag-uuid123',
            ],
        ];
    }
}
