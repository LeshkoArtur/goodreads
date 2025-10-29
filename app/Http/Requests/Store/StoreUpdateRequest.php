<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $store = $this->route('store');

        return $this->user()?->can('update', $store) ?? false;
    }

    public function rules(): array
    {
        $storeId = $this->route('store')->id;

        return [
            'name' => ['nullable', 'string', 'max:255', Rule::unique('stores', 'name')->ignore($storeId)],
            'logo_url' => ['nullable', 'url', 'max:255'],
            'region' => ['nullable', 'string', 'max:100'],
            'website_url' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва магазину.',
                'example' => 'Оновлена Книгарня Є',
            ],
            'logo_url' => [
                'description' => 'URL логотипу магазину.',
                'example' => 'https://example.com/logo.png',
            ],
            'region' => [
                'description' => 'Регіон розташування магазину.',
                'example' => 'Київ',
            ],
            'website_url' => [
                'description' => 'URL вебсайту магазину.',
                'example' => 'https://book-ye.com.ua',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'store' => [
                'description' => 'ID магазину для оновлення.',
                'example' => 'store-uuid123',
            ],
        ];
    }
}
