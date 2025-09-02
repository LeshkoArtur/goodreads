<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quote;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Quote.
 */
class QuotePolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма перевірками авторизації.
     *
     * @param User $user
     * @param string $ability
     * @return bool|null
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
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати цитату.
     *
     * @param User $user
     * @param Quote $quote
     * @return bool
     */
    public function view(User $user, Quote $quote): bool
    {
        return $quote->is_public || $quote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати цитати.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати цитату.
     *
     * @param User $user
     * @param Quote $quote
     * @return bool
     */
    public function update(User $user, Quote $quote): bool
    {
        return $quote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти цитату.
     *
     * @param User $user
     * @param Quote $quote
     * @return bool
     */
    public function delete(User $user, Quote $quote): bool
    {
        return $quote->user_id === $user->id;
    }
}
