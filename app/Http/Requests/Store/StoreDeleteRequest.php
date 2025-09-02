<?php

namespace App\Http\Requests\Store;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $store = $this->route('store');
        return $this->user()->can('delete', $store);
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
            'store' => [
                'description' => 'ID магазину для видалення.',
                'example' => 'store-uuid123',
            ],
        ];
    }
}
