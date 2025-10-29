<?php

namespace App\Http\Requests\Tag;

use App\Enums\TaggableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TagBulkAttachRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag_ids' => ['required', 'array', 'min:1'],
            'tag_ids.*' => ['uuid', 'exists:tags,id'],
            'taggable_type' => ['required', new Enum(TaggableType::class)],
            'taggable_id' => [
                'required',
                'uuid',
                function ($attribute, $value, $fail) {
                    $type = $this->input('taggable_type');
                    if (!$type) {
                        return;
                    }

                    $taggableType = TaggableType::tryFrom($type);
                    if (!$taggableType) {
                        return;
                    }

                    $modelClass = $taggableType->getModelClass();
                    if (!$modelClass::where('id', $value)->exists()) {
                        $fail("The selected {$attribute} does not exist.");
                    }
                },
            ],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'tag_ids' => [
                'description' => 'Масив UUID тегів для прикріплення.',
                'example' => '["9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a", "8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b"]',
            ],
            'taggable_type' => [
                'description' => 'Тип об\'єкта для тегування. Можливі значення: post.',
                'example' => 'post',
            ],
            'taggable_id' => [
                'description' => 'ID об\'єкта для тегування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
