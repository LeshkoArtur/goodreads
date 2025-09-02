<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Publisher;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Publisher.
 */
class PublisherPolicy
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
     * Визначає, чи може користувач переглядати будь-які видавництва.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати видавництво.
     *
     * @param User $user
     * @param Publisher $publisher
     * @return bool
     */
    public function view(User $user, Publisher $publisher): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати видавництва.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати видавництво.
     *
     * @param User $user
     * @param Publisher $publisher
     * @return bool
     */
    public function update(User $user, Publisher $publisher): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти видавництво.
     *
     * @param User $user
     * @param Publisher $publisher
     * @return bool
     */
    public function delete(User $user, Publisher $publisher): bool
    {
        return false;
    }
}
