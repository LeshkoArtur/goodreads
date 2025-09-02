<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReadingStat;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі ReadingStat.
 */
class ReadingStatPolicy
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
     * Визначає, чи може користувач переглядати будь-які статистики читання.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати статистику читання.
     *
     * @param User $user
     * @param ReadingStat $readingStat
     * @return bool
     */
    public function view(User $user, ReadingStat $readingStat): bool
    {
        return $readingStat->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати статистики читання.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати статистику читання.
     *
     * @param User $user
     * @param ReadingStat $readingStat
     * @return bool
     */
    public function update(User $user, ReadingStat $readingStat): bool
    {
        return $readingStat->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти статистику читання.
     *
     * @param User $user
     * @param ReadingStat $readingStat
     * @return bool
     */
    public function delete(User $user, ReadingStat $readingStat): bool
    {
        return $readingStat->user_id === $user->id;
    }
}
