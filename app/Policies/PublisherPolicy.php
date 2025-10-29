<?php

namespace App\Policies;

use App\Models\Publisher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Publisher.
 */
class PublisherPolicy
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
     * Визначає, чи може користувач переглядати будь-які видавництва.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати видавництво.
     */
    public function view(User $user, Publisher $publisher): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати видавництва.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати видавництво.
     */
    public function update(User $user, Publisher $publisher): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти видавництво.
     */
    public function delete(User $user, Publisher $publisher): bool
    {
        return false;
    }
}
