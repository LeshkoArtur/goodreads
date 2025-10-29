<?php

namespace App\Http\Requests\Group;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Group::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at,member_count'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'creator_id' => ['nullable', 'uuid', 'exists:users,id'],
            'is_public' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'join_policy' => ['nullable', Rule::enum(JoinPolicy::class)],
            'post_policy' => ['nullable', Rule::enum(PostPolicy::class)],
            'min_member_count' => ['nullable', 'integer', 'min:0'],
            'max_member_count' => ['nullable', 'integer', 'min:0'],
            'member_ids' => ['nullable', 'array'],
            'member_ids.*' => ['uuid', 'exists:users,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису групи.',
                'example' => 'Фентезійна література',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість груп на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, created_at, member_count).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'creator_id' => [
                'description' => 'Фільтр за ID творця групи.',
                'example' => 'user-uuid123',
            ],
            'is_public' => [
                'description' => 'Фільтр за видимістю групи.',
                'example' => true,
            ],
            'is_active' => [
                'description' => 'Фільтр за активністю групи.',
                'example' => true,
            ],
            'join_policy' => [
                'description' => 'Фільтр за політикою приєднання.',
                'example' => 'OPEN',
            ],
            'post_policy' => [
                'description' => 'Фільтр за політикою публікацій.',
                'example' => 'MEMBER',
            ],
            'min_member_count' => [
                'description' => 'Мінімальна кількість учасників у групі.',
                'example' => 1,
            ],
            'max_member_count' => [
                'description' => 'Максимальна кількість учасників у групі.',
                'example' => 1000,
            ],
            'member_ids' => [
                'description' => 'Фільтр за ID учасників (JSON масив).',
                'example' => '["user-uuid123", "user-uuid456"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
