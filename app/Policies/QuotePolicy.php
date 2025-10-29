<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Quote.
 */
class QuotePolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма перевірками авторизації.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Визначає, чи може користувач переглядати будь-які цитати.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати цитату.
     */
    public function view(User $user, Quote $quote): bool
    {
        return $quote->is_public || $quote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати цитати.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати цитату.
     */
    public function update(User $user, Quote $quote): bool
    {
        return $quote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти цитату.
     */
    public function delete(User $user, Quote $quote): bool
    {
        return $quote->user_id === $user->id;
    }
}
