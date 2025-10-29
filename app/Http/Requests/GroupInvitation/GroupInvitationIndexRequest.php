<?php

namespace App\Http\Requests\GroupInvitation;

use App\Enums\InvitationStatus;
use App\Models\GroupInvitation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupInvitationIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', GroupInvitation::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'uuid', 'exists:groups,id'],
            'inviter_id' => ['nullable', 'uuid', 'exists:users,id'],
            'invitee_id' => ['nullable', 'uuid', 'exists:users,id'],
            'status' => ['nullable', Rule::enum(InvitationStatus::class)],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит.',
                'example' => '',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість запрошень на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'group_id' => [
                'description' => 'Фільтр за UUID групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'inviter_id' => [
                'description' => 'Фільтр за UUID користувача, який запросив.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'invitee_id' => [
                'description' => 'Фільтр за UUID запрошеного користувача.',
                'example' => '7b5c6d1a-2c3d-4e5f-6a7b-8c9d0e1f2a3b',
            ],
            'status' => [
                'description' => 'Фільтр за статусом запрошення.',
                'example' => 'pending',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
