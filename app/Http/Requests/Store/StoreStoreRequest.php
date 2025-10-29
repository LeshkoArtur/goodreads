<?php

namespace App\Http\Requests\Store;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Store::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:stores,name'],
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
                'example' => 'Книгарня Є',
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
        return [];
    }
}
