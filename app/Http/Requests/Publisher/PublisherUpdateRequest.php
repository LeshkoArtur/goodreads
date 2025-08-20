<?php

namespace App\Http\Requests\Publisher;

use App\Models\Publisher;
use Illuminate\Foundation\Http\FormRequest;

class PublisherUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $publisher = $this->route('publisher');
        return $this->user()->can('update', $publisher);
    }

    public function rules(): array
    {
        $publisherId = $this->route('publisher')->id;

        return [
            'name' => ['nullable', 'string', 'max:255', Rule::unique('publishers', 'name')->ignore($publisherId)],
            'country' => ['nullable', 'string', 'max:100'],
            'founded_year' => ['nullable', 'integer', 'min:0', 'max:' . date('Y')],
            'contact_emails' => ['nullable', 'array'],
            'contact_emails.*' => ['email'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва видавця.',
                'example' => 'Оновлене Видавництво Старого Лева',
            ],
            'country' => [
                'description' => 'Країна видавця.',
                'example' => 'Україна',
            ],
            'founded_year' => [
                'description' => 'Рік заснування видавця.',
                'example' => 2001,
            ],
            'contact_emails' => [
                'description' => 'Масив контактних email видавця.',
                'example' => ['contact1@starylev.com.ua', 'contact2@starylev.com.ua'],
            ],
            'description' => [
                'description' => 'Опис видавця.',
                'example' => 'Оновлений опис видавництва.',
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
