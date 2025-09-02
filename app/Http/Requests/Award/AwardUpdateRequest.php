<?php

namespace App\Http\Requests\Award;

use App\Models\Award;
use Illuminate\Foundation\Http\FormRequest;

class AwardUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $award = $this->route('award');
        return $this->user()->can('update', $award);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'organizer' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'ceremony_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
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
            'description' => [
                'description' => 'Опис нагороди.',
                'example' => 'Премія за видатний внесок у літературу.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'award' => [
                'description' => 'ID нагороди для оновлення.',
                'example' => 'award-uuid123',
            ],
        ];
    }
}
