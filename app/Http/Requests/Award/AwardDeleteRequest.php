<?php

namespace App\Http\Requests\Award;

use App\Models\Award;
use Illuminate\Foundation\Http\FormRequest;

class AwardDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $award = $this->route('award');
        return $this->user()->can('delete', $award);
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'award' => [
                'description' => 'ID нагороди для видалення.',
                'example' => 'award-uuid123',
            ],
        ];
    }
}
