<?php

namespace App\Http\Requests\GroupInvitation;

use App\Models\GroupInvitation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupInvitationIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', GroupInvitation::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'string', 'exists:groups,id'],
            'inviter_id' => ['nullable', 'string', 'exists:users,id'],
            'invitee_id' => ['nullable', 'string', 'exists:users,id'],
            'status' => ['nullable', Rule::in(\App\Enums\InvitationStatus::values())],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для запрошень до груп.',
                'example' => 'Запрошення до книжкового клубу',
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
                'description' => 'Фільтр за ID групи.',
                'example' => 'group-uuid123',
            ],
            'inviter_id' => [
                'description' => 'Фільтр за ID запрошувача.',
                'example' => 'user-uuid123',
            ],
            'invitee_id' => [
                'description' => 'Фільтр за ID запрошеного.',
                'example' => 'user-uuid456',
            ],
            'status' => [
                'description' => 'Фільтр за статусом запрошення.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
