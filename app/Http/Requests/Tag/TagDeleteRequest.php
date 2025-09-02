<?php

namespace App\Http\Requests\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class TagDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $tag = $this->route('tag');
        return $this->user()->can('delete', $tag);
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
            'tag' => [
                'description' => 'ID тегу для видалення.',
                'example' => 'tag-uuid123',
            ],
        ];
    }
}
