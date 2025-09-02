<?php

namespace App\Http\Requests\Favorite;

use App\Models\Favorite;
use Illuminate\Foundation\Http\FormRequest;

class FavoriteDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $favorite = $this->route('favorite');
        return $this->user()->can('delete', $favorite);
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
            'favorite' => [
                'description' => 'ID улюбленого для видалення.',
                'example' => 'favorite-uuid123',
            ],
        ];
    }
}
