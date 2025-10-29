<?php

namespace App\Http\Requests\Publisher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublisherUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $publisher = $this->route('publisher');

        return $this->user()?->can('update', $publisher) ?? false;
    }

    public function rules(): array
    {
        $publisherId = $this->route('publisher')->id;

        return [
            'name' => ['nullable', 'string', 'max:100', Rule::unique('publishers', 'name')->ignore($publisherId)],
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
                'example' => 'Оновлене Видавництво Старого Лева',
            ],
            'description' => [
                'description' => 'Опис видавця.',
                'example' => 'Оновлений опис видавництва.',
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
        return [
            'publisher' => [
                'description' => 'ID видавця для оновлення.',
                'example' => 'publisher-uuid123',
            ],
        ];
    }
}
