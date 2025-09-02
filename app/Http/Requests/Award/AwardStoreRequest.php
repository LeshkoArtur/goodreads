<?php

namespace App\Http\Requests\Award;

use App\Models\Award;
use Illuminate\Foundation\Http\FormRequest;

class AwardStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Award::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1800', 'max:' . date('Y')],
            'description' => ['nullable', 'string'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'ceremony_date' => ['nullable', 'date'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва нагороди.',
                'example' => 'Нобелівська премія з літератури',
            ],
            'year' => [
                'description' => 'Рік отримання нагороди.',
                'example' => 2023,
            ],
            'description' => [
                'description' => 'Опис нагороди.',
                'example' => 'Премія за видатний внесок у літературу.',
            ],
            'organizer' => [
                'description' => 'Організатор нагороди.',
                'example' => 'Шведська академія',
            ],
            'country' => [
                'description' => 'Країна нагороди.',
                'example' => 'Швеція',
            ],
            'ceremony_date' => [
                'description' => 'Дата церемонії у форматі Y-m-d.',
                'example' => '2023-12-10',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
