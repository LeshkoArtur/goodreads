<?php

namespace App\DTOs;

use Illuminate\Http\Request;
use ReflectionClass;
use ReflectionException;

abstract class BaseDTO
{
    public static function fromRequest(Request $request): static
    {
        return self::fromArray($request->all());
    }

    private static function fromArray(array $data): static
    {
        $class = new ReflectionClass(static::class);
        try {
            return $class->newInstanceArgs(
                array_map(
                    fn($param) => $data[$param->getName()] ?? null,
                    $class->getConstructor()?->getParameters() ?? []
                )
            );
        } catch (ReflectionException $e) {
            # TODO: throw the exception or return null
        }
    }
}
