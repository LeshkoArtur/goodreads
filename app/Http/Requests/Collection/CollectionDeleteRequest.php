<?php

namespace App\Http\Requests\Collection;

use App\Models\Collection;
use Illuminate\Foundation\Http\FormRequest;

class CollectionDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $collection = $this->route('collection');
        return $this->user()->can('delete', $collection);
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
            'collection' => [
                'description' => 'ID колекції для видалення.',
                'example' => 'collection-uuid123',
            ],
        ];
    }
}
