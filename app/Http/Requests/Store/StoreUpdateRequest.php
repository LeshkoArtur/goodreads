<?php

namespace App\Http\Requests\Store;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $store = $this->route('store');
        return $this->user()->can('update', $store);
    }

    public function rules(): array
    {
        $storeId = $this->route('store')->id;

        return [
            'name' => ['nullable', 'string', 'max:255', Rule::unique('stores', 'name')->ignore($storeId)],
            'country' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', 'string', 'in:BOOKSTORE,LIBRARY,MARKETPLACE'],
            'is_online' => ['nullable', 'boolean'],
            'website' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва магазину.',
                'example' => 'Оновлена Книгарня Є',
            ],
            'country' => [
                'description' => 'Країна магазину.',
                'example' => 'Україна',
            ],
            'type' => [
                'description' => 'Тип магазину (BOOKSTORE, LIBRARY, MARKETPLACE).',
                'example' => 'BOOKSTORE',
            ],
            'is_online' => [
                'description' => 'Онлайн/офлайн статус магазину.',
                'example' => true,
            ],
            'website' => [
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
