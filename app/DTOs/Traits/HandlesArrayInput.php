<?php

namespace App\DTOs\Traits;

use Illuminate\Http\Request;

trait HandlesArrayInput
{
    /**
     * Безпечна обробка поля, яке може бути масивом або рядком зі значеннями, розділеними комами.
     *
     * @param Request $request HTTP-запит
     * @param string $key Ключ поля у запиті
     * @return array|null
     */
    private static function processArrayInput(Request $request, string $key): ?array
    {
        if (!$request->has($key)) {
            return null;
        }

        $input = $request->input($key);

        if (is_string($input)) {
            $items = array_map('trim', explode(',', $input));
            return array_values(array_filter($items, fn($v) => $v !== ''));
        }

        if (is_array($input)) {
            return array_values($input);
        }

        return null;
    }
}
