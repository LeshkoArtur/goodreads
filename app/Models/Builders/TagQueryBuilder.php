<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class TagQueryBuilder extends Builder
{
    /**
     * Теги з певною назвою (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Теги, пов’язані з постами.
     */
    public function withPosts(): static
    {
        return $this->has('posts');
    }
}
