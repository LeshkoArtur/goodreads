<?php

namespace App\Http\Requests\Tag;

use App\Enums\TaggableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TagDetachRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
            'taggable_type' => [
                'description' => 'Тип об\'єкта для видалення тегу. Можливі значення: post.',
                'example' => 'post',
            ],
            'taggable_id' => [
                'description' => 'ID об\'єкта для видалення тегу.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'tag' => [
                'description' => 'ID тегу.',
                'example' => 'tag-uuid123',
            ],
        ];
    }
}
