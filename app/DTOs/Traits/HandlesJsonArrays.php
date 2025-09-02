<?php

namespace App\DTOs\Traits;

use Illuminate\Support\Collection;

trait HandlesJsonArrays
{
    /**
     * Безпечна обробка поля, яке може бути JSON-рядком або масивом/колекцією
     *
     * @param mixed $value
     * @return array|Collection|null
     */
    protected static function processJsonArray(mixed $value): array|Collection|null
    {
        if (is_null($value)) {
            return null;
        }

        if (is_array($value) || $value instanceof Collection) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || $decoded instanceof Collection)) {
                return $decoded;
            }
        }

        return null;
    }
}
