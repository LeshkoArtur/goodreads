<?php

namespace App\Http\Requests\Publisher;

use App\Models\Publisher;
use Illuminate\Foundation\Http\FormRequest;

class PublisherStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Publisher::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:publishers,name'],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'country' => ['nullable', 'string', 'max:50'],
            'founded_year' => ['nullable', 'integer', 'min:0', 'max:'.date('Y')],
            'logo' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:376'],
            'phone' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва видавця.',
                'example' => 'Видавництво Старого Лева',
            ],
            'description' => [
                'description' => 'Опис видавця.',
                'example' => 'Провідне українське видавництво.',
            ],
            'website' => [
                'description' => 'Вебсайт видавця.',
                'example' => 'https://starylev.com.ua',
            ],
            'country' => [
                'description' => 'Країна видавця.',
                'example' => 'Україна',
            ],
            'founded_year' => [
                'description' => 'Рік заснування видавця.',
                'example' => 2001,
            ],
            'logo' => [
                'description' => 'URL або шлях до логотипу видавця.',
                'example' => '/images/logo.png',
            ],
            'contact_email' => [
                'description' => 'Контактна електронна пошта видавця.',
                'example' => 'contact@starylev.com.ua',
            ],
            'phone' => [
                'description' => 'Контактний телефон видавця.',
                'example' => '+380123456789',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
