<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ShelfQueryBuilder extends Builder
{
    /**
     * Полиці, що належать певному користувачу.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Полиці з певною назвою (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Полиці, що містять книги.
     */
    public function withBooks(): static
    {
        return $this->has('userBooks');
    }
}
